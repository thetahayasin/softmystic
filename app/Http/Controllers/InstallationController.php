<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule; // Added for 'nullable' in production

class InstallationController extends Controller
{
    public function step1()
    {

        $extensions = ['pdo', 'mbstring', 'openssl', 'tokenizer', 'json', 'xml'];

        $phpVersion = phpversion();
        $laravelVersion = app()->version();

        $requirements = [
            'php' => [
                'current' => $phpVersion,
                'required' => '8.1.0',
                'status' => version_compare($phpVersion, '8.1.0', '>='),
            ],
            'laravel' => [
                'current' => $laravelVersion,
                'required' => '12.0.0',
                'status' => version_compare($laravelVersion, '12.0.0', '>='),
            ],
        ];

        return view('install.step1', compact('extensions', 'requirements'));
    }


    public function postStep1()
    {
        return redirect()->route('install.step2');
    }

    public function step2()
    {
        return view('install.step2');
    }

    public function postStep2(Request $request)
    {
        $validatedData = $request->validate([
            'db_connection' => 'required',
            'db_host' => 'required',
            'db_port' => 'required',
            'db_database' => 'required',
            'db_username' => 'required',
            'db_password' => 'nullable',
            'app_name' => 'required',
            'app_url' => 'required|url', // Added 'url' validation rule

            // Mail Configuration Fields
            'mail_mailer' => 'nullable|string',
            'mail_host' => 'nullable|string',
            'mail_port' => 'nullable|numeric',
            'mail_username' => 'nullable|string',
            'mail_password' => 'nullable|string',
            'mail_encryption' => ['nullable', 'string', Rule::in(['tls', 'ssl', 'null', ''])], // Added 'null' and empty string for cases where no encryption is used
            'mail_from_address' => 'required|email', // Required as per your form
            // 'mail_from_name' => 'nullable|string', // Removed as requested
        ]);

        // Update .env file for database, app, and mail settings
        $this->updateEnv([
            'DB_CONNECTION' => $validatedData['db_connection'],
            'DB_HOST' => $validatedData['db_host'],
            'DB_PORT' => $validatedData['db_port'],
            'DB_DATABASE' => $validatedData['db_database'],
            'DB_USERNAME' => $validatedData['db_username'],
            'DB_PASSWORD' => $validatedData['db_password'],
            'APP_NAME' => $validatedData['app_name'],
            'APP_URL' => $validatedData['app_url'],

            // Mail Configuration Values
            'MAIL_MAILER' => $validatedData['mail_mailer'] ?? 'smtp', // Default to smtp if null
            'MAIL_HOST' => $validatedData['mail_host'],
            'MAIL_PORT' => $validatedData['mail_port'],
            'MAIL_USERNAME' => $validatedData['mail_username'],
            'MAIL_PASSWORD' => $validatedData['mail_password'],
            'MAIL_ENCRYPTION' => $validatedData['mail_encryption'] === '' ? 'null' : $validatedData['mail_encryption'], // Convert empty string to 'null' for .env
            'MAIL_FROM_ADDRESS' => $validatedData['mail_from_address'],
            // 'MAIL_FROM_NAME' => $validatedData['mail_from_name'], // Removed as requested
        ]);


    // Set up the database connection configuration dynamically
    config([
        'database.default' => $validatedData['db_connection'],
        'database.connections.' . $validatedData['db_connection'] => [
            'driver' => $validatedData['db_connection'],
            'host' => $validatedData['db_host'],
            'port' => $validatedData['db_port'],
            'database' => $validatedData['db_database'],
            'username' => $validatedData['db_username'],
            'password' => $validatedData['db_password'],
        ]
    ]);

    // Also update mail config dynamically for immediate testing if needed
    config([
        'mail.mailers.smtp.transport' => $validatedData['mail_mailer'] ?? 'smtp',
        'mail.mailers.smtp.host' => $validatedData['mail_host'],
        'mail.mailers.smtp.port' => $validatedData['mail_port'],
        'mail.mailers.smtp.username' => $validatedData['mail_username'],
        'mail.mailers.smtp.password' => $validatedData['mail_password'],
        'mail.mailers.smtp.encryption' => $validatedData['mail_encryption'] === '' ? null : $validatedData['mail_encryption'],
        'mail.from.address' => $validatedData['mail_from_address'],
        // 'mail.from.name' => $validatedData['mail_from_name'], // Removed as requested
    ]);


    try {
        // Test the DB connection
        DB::connection()->getPdo();
    } catch (\Exception $e) {
        // If the connection fails, return back with an error message
        return back()->with('error', '❌ Could not connect to database: ' . $e->getMessage())->withInput();
    }

        return redirect()->route('install.step3');
    }

    public function step3()
    {
        return view('install.step3');
    }

    public function postStep3(Request $request)
    {
        // Validate super admin details with confirmation rule
        $validatedData = $request->validate([
            'admin_name' => 'required',
            'admin_email' => 'required|email',
            'admin_password' => 'required|confirmed', // This ensures password and confirmation match
        ]);

        try {
            // Run migrations
            Artisan::call('migrate:fresh', ['--force' => true]);

            // Run seeder
            Artisan::call('db:seed', ['--force' => true]);

            // Create super admin user
            $user = \App\Models\User::create([
                'name' => $validatedData['admin_name'],
                'email' => $validatedData['admin_email'],
                'password' => \Hash::make($validatedData['admin_password']),
                'email_verified_at' => now(),
            ]);

            // Assign the super_admin role
            $user->assignRole('super_admin'); // 👈 Make sure 'super_admin' role exists

            // Update .env file settings
            $this->updateEnv([

                'APP_INSTALLED' => true,
                'APP_DEBUG' => false,
                'APP_ENV' => "production",
            ]);


            Artisan::call('storage:link');
        } catch (\Throwable $e) {
            return back()->with('error', 'Installation failed: ' . $e->getMessage());
        }

        return redirect()->route('filament.admin.auth.login');
    }

    protected function updateEnv(array $data)
    {
        $envPath = base_path('.env');
        $content = File::get($envPath);

        foreach ($data as $key => $value) {
            $envKey = strtoupper($key);

            if (is_bool($value)) {
                $value = $value ? 'true' : 'false';
            } elseif ($value === null || $value === '') { // Handle null or empty string for .env as 'null'
                $value = 'null';
            } elseif ($envKey === 'APP_NAME' || $envKey === 'MAIL_FROM_NAME' || $envKey === 'MAIL_FROM_ADDRESS') { // Ensure these are quoted
                $value = '"' . addslashes($value) . '"';
            }

            // Replace if key exists
            if (preg_match("/^$envKey=.*$/m", $content)) {
                $content = preg_replace("/^$envKey=.*$/m", "$envKey=$value", $content);
            } else {
                // Add new key if it doesn't exist
                $content .= "\n$envKey=$value";
            }
        }

        File::put($envPath, $content);
    }
}
