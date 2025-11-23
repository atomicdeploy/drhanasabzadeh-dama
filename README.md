# drhanasabzadeh-dama

The dama-ng app ported from drhanasabzadeh.ir's legacy code.

This is a monorepo for the Dr. Hana Sabzadeh application platform, containing both the mobile app, admin panel, and shared utilities.

## Project Structure

```
drhanasabzadeh-dama/
├── package.json          # Root package.json with npm workspaces
├── packages/
│   ├── share/           # @yektayar/share - Shared utilities
│   ├── mobile-app/      # Vue3 mobile web application
│   └── admin-panel/     # Laravel 8 admin panel
└── README.md
```

## Quick Start

```bash
# Install all dependencies
npm install

# Build all packages (share → mobile → admin)
npm run build

# Build individual packages
npm run build:share
npm run build:mobile
npm run build:admin

# Development
npm run dev:mobile
```

## Packages

### Shared Package (`packages/share`) ✅ NEW

`@yektayar/share` - Common utilities and constants used across applications.

**Features:**
- TypeScript with type definitions
- Constants (app config, date formats, locales)
- Helper functions (formatNumber, truncate, isEmpty, deepClone)
- Built to ESM and CommonJS formats

See [packages/share/README.md](packages/share/README.md) for details.

### Mobile App (`packages/mobile-app`) ✅

Vue3-based progressive web application extracted from the production deployment at https://drhanasabzadeh.ir/

The source code was reconstructed from production builds using source maps, providing a complete 1:1 replica of the legacy codebase.

**Recent Improvements:**
- ✅ Enhanced i18n with missing key detection and logging
- ✅ Build-time i18n validation
- ✅ Missing translation placeholders instead of raw keys

See [packages/mobile-app/README.md](packages/mobile-app/README.md) for details.

### Admin Panel (`packages/admin-panel`) ✅

Laravel 8.83.29 admin panel imported from https://panel.drhanasabzadeh.ir/

Imported with authenticated session crawling:
- 40 admin pages (HTML snapshots)
- 9 MB of static assets (CSS, JS, plugins, fonts)
- Complete route structure documented
- Ready for Blade template conversion

See [packages/admin-panel/README.md](packages/admin-panel/README.md) for details.

## Recent Improvements

### Build Order Fix ✅

Implemented proper monorepo structure with npm workspaces:
- Root package.json orchestrates builds
- Correct build order: `@yektayar/share` → `mobile-app` → `admin-panel`
- Shared package built first, ensuring other packages can use it

### i18n Improvements ✅

Enhanced internationalization with comprehensive missing key handling:

**Runtime:**
- Missing keys display as `[Missing: keyname]` instead of raw keys
- Console warnings alert developers to missing translations
- Tracking of all missing keys for summary reporting

**Build-time:**
- Validation script checks locale file consistency
- Reports missing translations before build
- Prevents shipping incomplete translations

See [BUILD_AND_I18N_IMPROVEMENTS.md](BUILD_AND_I18N_IMPROVEMENTS.md) for detailed documentation.

## Import Process

This repository was created by:

1. **Asset Discovery**: Downloaded 145+ JavaScript chunks, CSS files, and source maps from the live site
2. **Source Extraction**: Used reverse-sourcemap to extract original Vue components from source maps
3. **Structure Reconstruction**: Merged extracted files into proper Vue3 project structure
4. **Dependency Analysis**: Identified all npm packages and created package.json
5. **Configuration**: Set up vue.config.js matching the original build configuration

### Extracted Components

- **Views**: 47 page components
- **Components**: 15 reusable components  
- **Stores**: Pinia state management (permStore, tempStore)
- **Router**: Complete routing configuration
- **Locales**: i18n setup (placeholder files)

## Future Improvements

Planned improvements for subsequent PRs:

- Complete locale files with actual translations (195 keys identified)
- Code modernization (composition API migration)
- TypeScript migration
- Testing setup (Vitest/Jest)
- ESLint and Prettier configuration
- CI/CD pipeline
- Performance optimizations
- Accessibility improvements
- Security hardening
- Comprehensive documentation

## Development

See individual package READMEs for development instructions.

## Documentation

- [BUILD_AND_I18N_IMPROVEMENTS.md](BUILD_AND_I18N_IMPROVEMENTS.md) - Build order and i18n improvements
- [IMPORT_NOTES.md](IMPORT_NOTES.md) - Mobile app import process
- [STATUS_REPORT.md](STATUS_REPORT.md) - Current status and progress
