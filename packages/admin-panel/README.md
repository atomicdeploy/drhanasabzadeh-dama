# Admin Panel - Dr. Hana Sabzadeh

Laravel 8.83.29 admin panel imported from production deployment at https://panel.drhanasabzadeh.ir/

## About

This is the admin-panel package imported from the legacy Laravel application. The project has been recreated with all static assets, HTML snapshots, and proper structure for future Blade template conversion.

## Import Summary

### What Was Imported

1. **Static Assets** (9 MB)
   - CSS files (9 files)
   - JavaScript files (14 files)
   - Images and icons
   - Fonts (FontAwesome Pro 6.1.1)
   - Third-party plugins (FullCalendar, PrismJS, etc.)
   - KamaDatePicker (Persian date picker)

2. **HTML Snapshots** (40 pages, 3.5 MB)
   - All admin pages crawled with authenticated session
   - Saved in `resources/static-html/` for reference
   - Ready for Blade template conversion

3. **Route Structure**
   - 40+ unique admin routes discovered
   - Navigation menus analyzed
   - Form structures documented

## Project Structure

```
packages/admin-panel/
├── app/                      # Laravel application logic
├── public/                   # Public web root
│   ├── adminassets/         # ✅ Admin static assets (imported)
│   │   ├── css/             # Styles (RTL support)
│   │   ├── js/              # Scripts and widgets
│   │   ├── plugins/         # Third-party plugins
│   │   └── media/           # Icons and images
│   └── index.php            # Entry point
├── resources/
│   ├── static-html/         # ✅ Crawled HTML pages (40 pages)
│   └── views/               # Blade templates (to be created)
├── routes/
│   ├── web.php              # Web routes (to be defined)
│   └── api.php              # API routes
└── README.md                # This file
```

## Technology Stack

- **Framework**: Laravel 8.83.29
- **PHP**: 8.2.18 compatible
- **Frontend**: Bootstrap/Metronic theme (RTL), ApexCharts, FontAwesome Pro 6.1.1

## Discovered Routes (40 pages)

Dashboard, Content Management, Course Management, User Management, Orders, Settings, and more.

See ADMIN_PANEL_IMPORT_PLAN.md in root for complete route listing.

## Setup

```bash
cd packages/admin-panel
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

## Next Steps

1. ✅ Laravel project initialized
2. ✅ Static assets imported  
3. ✅ HTML pages crawled
4. ⏳ Convert HTML to Blade templates
5. ⏳ Define routes and controllers
6. ⏳ Create database migrations
