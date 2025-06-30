# Software Directory & Download Platform

A modern, multilingual, and multi-platform software directory and download portal built with Laravel, Filament, and Livewire. This project enables you to showcase, categorize, and distribute software with rich metadata, ratings, and translation support.

## Features

- **Multilingual**: Full translation support for software, categories, licenses, and site content.
- **Multi-Platform**: Organize and filter software by platform (e.g., Windows, Mac, Linux).
- **Category Browsing**: Users can browse software by categories with localized descriptions.
- **Software Details**: Rich detail pages for each software, including version, author, license, screenshots, and changelogs.
- **Download Management**: Direct download links, download tracking, and post-download pages.
- **Ratings & Reviews**: Users can rate software (Livewire-powered).
- **Admin Panel**: Powerful admin interface using Filament for managing all resources.
- **SEO Optimized**: Meta tags, Open Graph, Twitter Cards, and structured data for better search engine visibility.
- **Advertisement Slots**: Easily manage ad placements on key pages.
- **Responsive Design**: Beautiful, modern UI that works on all devices.

## Tech Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade, Tailwind CSS, Filament UI, Livewire, DaisyUI
- **Database**: MySQL (or any Laravel-supported DB)
- **Admin Panel**: Filament
- **Testing**: PHPUnit

## Quick Start

1. Clone the repository and install dependencies:
   ```bash
   git clone https://github.com/yourusername/your-repo.git
   cd your-repo
   composer install
   npm install && npm run build
   ```

2. Visit `http://localhost:8000/install` in your browser.

3. Follow the three-step installer:
   - **Step 1:** System requirements check
   - **Step 2:** Database and mail configuration
   - **Step 3:** Super admin account setup

4. After installation, you'll be redirected to the admin login page.

### Admin Panel

- Access the admin panel at `/mystic` (Filament).
- Default credentials: (set via installer).

### Configuration

- Update site settings, logo, and ads via the admin panel.
- Add locales and platforms for multilingual and multi-platform support.

## Folder Structure

- `app/Models/` - Eloquent models for all entities (Software, Category, Locale, etc.)
- `app/Http/Controllers/` - Controllers for frontend and API logic
- `resources/views/` - Blade templates for frontend
- `app/Filament/Admin/Resources/` - Filament resource definitions for admin panel
- `database/migrations/` - Database schema
- `database/seeders/` - Initial data
- `public/` - Public assets and entry point

## Customization

- **Themes**: Easily switch themes from admin panel (Supports all DaisyUI 4 Themes).
- **Translations**: Add new languages via the admin.
- **Ads**: Manage ad slots from the admin panel.

## Contributing

Pull requests are welcome! For major changes, please open an issue first to discuss what you would like to change.

## License

This software is licensed under the End User License Agreement (EULA).
