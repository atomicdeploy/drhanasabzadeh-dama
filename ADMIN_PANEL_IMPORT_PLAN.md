# Admin Panel Import Plan

## Overview
Import the Laravel v8.83.27 (PHP v8.2.18) admin panel from https://panel.drhanasabzadeh.ir/ into the monorepo structure at `packages/admin-panel/`.

## Credentials
- URL: https://panel.drhanasabzadeh.ir/l
- Username: `drmaryam`
- Password: `hn@ps##1`
- Note: Dev server serves easy captcha for testing

## Phase 1: Authentication & Session Management
- [x] Fetch login page with cookie jar persistence
- [x] Extract CSRF token from login form
- [x] Download captcha image (saved to `.admin-download-workspace/captcha.png`)
- [ ] Wait for captcha value (automatic after ~60s)
- [ ] Perform login POST with credentials + captcha
- [ ] Verify authentication success
- [ ] Store authenticated session cookies

## Phase 2: Route Discovery
- [ ] Access `/admin/dashboard` to verify authentication
- [ ] Discover available routes by:
  - Analyzing navigation menus in dashboard
  - Checking JavaScript route definitions
  - Following links in admin interface
  - Examining Laravel routing patterns
- [ ] Create comprehensive route map
- [ ] Document route structure and hierarchy

## Phase 3: Static Asset Download
- [ ] Download all assets from `/adminassets/` directory:
  - CSS files
  - JavaScript files
  - Images
  - Fonts
  - Icons
  - Other static resources
- [ ] Maintain directory structure
- [ ] Document asset dependencies

## Phase 4: Page Crawling & HTML Extraction
- [ ] Crawl all discovered routes with authenticated session
- [ ] Save HTML responses for each page
- [ ] Extract:
  - Page structure
  - Forms and their fields
  - Data tables
  - Navigation elements
  - Embedded scripts
- [ ] Document page relationships and workflows

## Phase 5: Laravel Project Initialization
- [ ] Create `packages/admin-panel/` directory
- [ ] Initialize Laravel 8.83.27 project
- [ ] Configure for PHP 8.2.18
- [ ] Set up basic structure:
  - routes/
  - app/Http/Controllers/
  - resources/views/
  - public/
  - config/
  - database/

## Phase 6: Asset Integration
- [ ] Copy downloaded static assets to Laravel `public/` directory
- [ ] Organize assets properly:
  - `public/adminassets/css/`
  - `public/adminassets/js/`
  - `public/adminassets/images/`
  - etc.
- [ ] Update asset paths if needed

## Phase 7: Blade Template Creation (Future)
**Note**: This phase will be done later, but plan now:
- [ ] Convert static HTML pages to Blade templates
- [ ] Identify:
  - Layout templates (master.blade.php)
  - Partials (header, footer, sidebar)
  - Component templates
  - Form templates
- [ ] Extract dynamic data patterns
- [ ] Create Blade directives and components
- [ ] Implement template inheritance

## Phase 8: Route Definition (Future)
- [ ] Define web routes in `routes/web.php`
- [ ] Define API routes in `routes/api.php`
- [ ] Map routes to controllers
- [ ] Implement middleware (auth, csrf, etc.)

## Phase 9: Controller Implementation (Future)
- [ ] Create controllers for each route group
- [ ] Implement CRUD operations based on forms
- [ ] Handle authentication logic
- [ ] Implement authorization
- [ ] Add validation rules

## Phase 10: HTTP Analysis & Implementation
By analyzing server responses, understand:
- [ ] Authentication mechanism (cookies, sessions)
- [ ] CSRF protection implementation
- [ ] API endpoint structures
- [ ] Request/response patterns
- [ ] Data formats (JSON, form data)
- [ ] Error handling patterns
- [ ] Session management
- [ ] Security headers

## Phase 11: Database Schema (Future)
- [ ] Infer database schema from:
  - Forms and their fields
  - Data tables and columns
  - Relationships in the UI
- [ ] Create migrations
- [ ] Define models
- [ ] Set up relationships

## Technical Considerations

### Cookie Persistence
- Use curl with `-c` (write cookies) and `-b` (read cookies)
- Maintain cookie jar throughout entire session
- Cookies include:
  - `laravel_session`
  - `XSRF-TOKEN`
  - Application-specific cookies

### Laravel Version Specifics
- Laravel 8.83.27 (released ~2022)
- PHP 8.2.18 compatibility
- Blade templating engine
- Eloquent ORM
- Laravel Mix or Vite for assets

### Authentication Flow
1. GET `/l` - Fetch login page + initial cookies
2. Extract CSRF token from form
3. Solve captcha (easy mode on dev)
4. POST `/panel` with:
   - `_token` (CSRF)
   - `username`
   - `password`
   - `captcha`
5. Follow redirects with cookies
6. Access protected routes with session

## Project Structure (Target)

```
packages/admin-panel/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   └── Requests/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── adminassets/
│   │   ├── css/
│   │   ├── js/
│   │   ├── images/
│   │   └── fonts/
│   └── index.php
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   ├── partials/
│   │   └── admin/
│   └── lang/
├── routes/
│   ├── web.php
│   └── api.php
├── storage/
├── tests/
├── .env.example
├── artisan
├── composer.json
└── README.md
```

## Commit Strategy
Each phase will have meaningful commits:
- "Add authentication and session management for admin panel"
- "Download and organize admin static assets"
- "Create Laravel project structure for admin panel"
- "Add route definitions for admin dashboard"
- "Implement admin controllers and views"
- etc.

## Success Criteria
- [ ] All static assets downloaded and organized
- [ ] Complete Laravel project initialized
- [ ] All admin routes documented
- [ ] HTML snapshots saved for all pages
- [ ] Asset paths working correctly
- [ ] Foundation ready for Blade conversion
- [ ] Clear documentation of current server behavior

## Next Steps After Import
1. Convert static HTML to Blade templates
2. Implement dynamic data handling
3. Set up database and migrations
4. Implement authentication and authorization
5. Add form validation and processing
6. Test all functionality
7. Optimize and refactor
