# Getting Started - Admin Panel

## Prerequisites

- PHP 8.2+ (tested with PHP 8.3.6)
- Composer 2.x
- MySQL/MariaDB (optional for initial testing)
- Git

## Quick Start

### 1. Navigate to Admin Panel Directory

```bash
cd packages/admin-panel
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Environment Setup

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database (Optional)

Edit `.env` file and update database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=admin_panel
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

**Note**: For initial testing, database is not required. Laravel will work with file-based session and cache.

### 5. Start Development Server

```bash
php artisan serve
```

The application will be available at: http://localhost:8000

## Project Structure

```
packages/admin-panel/
├── app/                    # Application logic
│   ├── Http/
│   │   ├── Controllers/   # Controllers (to be created)
│   │   └── Middleware/    # Middleware
│   └── Models/            # Eloquent models (to be created)
├── config/                # Configuration files
├── database/              # Migrations and seeders
│   └── migrations/        # Database migrations (to be created)
├── public/                # Public web root
│   └── adminassets/       # ✅ Static assets (9 MB)
│       ├── css/           # Stylesheets with RTL support
│       ├── js/            # JavaScript files
│       ├── plugins/       # Third-party plugins
│       └── media/         # Images and icons
├── resources/
│   ├── static-html/       # ✅ 40 crawled HTML pages
│   └── views/             # Blade templates (to be created)
├── routes/
│   ├── web.php           # Web routes (to be defined)
│   └── api.php           # API routes
├── storage/              # Storage directory
├── .env                  # Environment configuration
└── artisan              # Artisan command-line tool
```

## Verification

### Check Laravel Version

```bash
php artisan --version
# Output: Laravel Framework 8.83.29
```

### List Current Routes

```bash
php artisan route:list
```

### Run Tests (Optional)

```bash
php artisan test
```

## Available Static Assets

### CSS Files (9 files)
- Main bundle with RTL support
- Theme variations (aside, brand, header, menu)
- Plugin styles (PrismJS, global plugins)
- KamaDatePicker (Persian calendar)
- FontAwesome Pro 6.1.1

### JavaScript Files (14 files)
- Core scripts bundle
- Page-specific scripts (widgets, charts, file upload)
- Third-party plugins (FullCalendar, GMaps, PrismJS)
- Form widgets (Select2, timepicker, datatables)

### HTML Snapshots (40 pages)
Located in `resources/static-html/`:
- Dashboard and analytics
- Content management (categories, channels, posts, stories)
- Course management (exams, live sessions)
- User management (users, teachers)
- Orders, discounts, messaging
- Settings and customization

## Development Workflow

### Phase 1: Current State ✅
- Laravel 8.83.29 initialized
- All static assets imported
- 40 HTML pages crawled
- Development server working

### Phase 2: Next Steps
1. **Create Blade Templates**
   - Extract layout from dashboard.html
   - Create master layout (header, sidebar, footer)
   - Convert HTML pages to Blade templates

2. **Define Routes**
   - Add routes in `routes/web.php`
   - Implement route groups with middleware

3. **Create Controllers**
   - Dashboard controller
   - Content management controllers
   - User management controllers
   - Settings controllers

4. **Database Setup**
   - Create migrations based on forms
   - Define Eloquent models
   - Set up relationships

5. **Implement Authentication**
   - Set up Laravel authentication
   - Add admin middleware
   - Implement role-based permissions

## Common Commands

### Development

```bash
# Start development server
php artisan serve

# Start with specific host/port
php artisan serve --host=0.0.0.0 --port=8000

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Database

```bash
# Run migrations
php artisan migrate

# Rollback migrations
php artisan migrate:rollback

# Seed database
php artisan db:seed

# Fresh migration with seeding
php artisan migrate:fresh --seed
```

### Code Generation

```bash
# Create controller
php artisan make:controller DashboardController

# Create model with migration
php artisan make:model Category -m

# Create middleware
php artisan make:middleware CheckAdmin

# Create request validator
php artisan make:request StoreCategoryRequest
```

## Troubleshooting

### Permission Issues

```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
```

### Clear All Caches

```bash
php artisan optimize:clear
```

### Composer Issues

```bash
# Update dependencies
composer update

# Dump autoload
composer dump-autoload
```

## Technology Stack

- **Framework**: Laravel 8.83.29
- **PHP**: 8.2+ (tested with 8.3.6)
- **Frontend**: 
  - Metronic admin theme (Bootstrap, RTL)
  - FontAwesome Pro 6.1.1
  - ApexCharts
  - KamaDatePicker (Persian calendar)
  - FullCalendar
  - Select2, DropzoneJS

## Resources

- [Laravel 8.x Documentation](https://laravel.com/docs/8.x)
- [Metronic Theme Documentation](https://keenthemes.com/metronic/)
- Project Documentation:
  - `README.md` - Package overview
  - `ROUTES.txt` - All 40 discovered routes
  - `../ADMIN_PANEL_IMPORT_PLAN.md` - Import strategy
  - `../ADMIN_IMPORT_SUMMARY.md` - Import summary

## Support

For issues or questions:
1. Check the documentation files
2. Review the static HTML pages in `resources/static-html/`
3. Check Laravel logs in `storage/logs/`

## Next Development Tasks

1. ✅ Laravel installed and working
2. ✅ Static assets integrated
3. ✅ HTML pages available for reference
4. ⏳ Create master Blade layout
5. ⏳ Define admin routes
6. ⏳ Implement controllers
7. ⏳ Create database migrations
8. ⏳ Set up authentication

---

**Last Updated**: 2025-11-22  
**Laravel Version**: 8.83.29  
**Status**: ✅ Ready for Development
