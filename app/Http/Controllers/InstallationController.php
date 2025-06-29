<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

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
            'app_url' => 'required',
        ]);

        // Map the validated data to variables
        $dbConnection = $validatedData['db_connection'];
        $dbHost = $validatedData['db_host'];
        $dbPort = $validatedData['db_port'];
        $dbDatabase = $validatedData['db_database'];
        $dbUsername = $validatedData['db_username'];
        $dbPassword = $validatedData['db_password'];
        $appName = $validatedData['app_name'];
        $appUrl = $validatedData['app_url'];

        // Update .env file for database and app settings
        $this->updateEnv([
            'DB_CONNECTION' => $validatedData['db_connection'],
            'DB_HOST' => $validatedData['db_host'],
            'DB_PORT' => $validatedData['db_port'],
            'DB_DATABASE' => $validatedData['db_database'],
            'DB_USERNAME' => $validatedData['db_username'],
            'DB_PASSWORD' => $validatedData['db_password'],
            'APP_NAME' => $validatedData['app_name'],
            'APP_URL' => $validatedData['app_url'],
        ]);


    // Set up the database connection configuration dynamically
    config([
        'database.default' => $dbConnection,
        'database.connections.' . $dbConnection => [
            'driver' => $dbConnection,
            'host' => $dbHost,
            'port' => $dbPort,
            'database' => $dbDatabase,
            'username' => $dbUsername,
            'password' => $dbPassword,
        ]
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
            } elseif ($envKey === 'APP_NAME') {
                $value = '"' . addslashes($value) . '"';
            }
    
            // Replace if key exists
            if (preg_match("/^$envKey=.*$/m", $content)) {
                $content = preg_replace("/^$envKey=.*$/m", "$envKey=$value", $content);
            } else {
                $content .= "\n$envKey=$value";
            }
        }
    
        File::put($envPath, $content);
    }
    
    
    
    
}
