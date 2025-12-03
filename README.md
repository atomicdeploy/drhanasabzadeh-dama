# drhanasabzadeh-dama

The dama-ng app ported from drhanasabzadeh.ir's legacy code.

This is a monorepo for the Dr. Hana Sabzadeh application platform, containing both the mobile app and admin panel.

## Project Structure

```
drhanasabzadeh-dama/
├── packages/
│   ├── mobile-app/     # Vue3 mobile web application
│   └── admin-panel/    # Laravel 8 admin panel
└── README.md
```

## Packages

### Mobile App (`packages/mobile-app`) ✅

Vue3-based progressive web application extracted from the production deployment at https://drhanasabzadeh.ir/

The source code was reconstructed from production builds using source maps, providing a complete 1:1 replica of the legacy codebase.

See [packages/mobile-app/README.md](packages/mobile-app/README.md) for details.

### Admin Panel (`packages/admin-panel`) ✅

Laravel 8.83.29 admin panel imported from https://panel.drhanasabzadeh.ir/

Imported with authenticated session crawling:
- 40 admin pages (HTML snapshots)
- 9 MB of static assets (CSS, JS, plugins, fonts)
- Complete route structure documented
- Ready for Blade template conversion

See [packages/admin-panel/README.md](packages/admin-panel/README.md) for details.

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

- Complete locale files with actual translations
- Code modernization (composition API migration)
- TypeScript migration
- Testing setup (Vitest/Jest)
- ESLint and Prettier configuration
- CI/CD pipeline
- Performance optimizations
- Accessibility improvements
- Security hardening
- Comprehensive documentation
- Monorepo tooling (Lerna/Nx/Turborepo)

## Development

See individual package READMEs for development instructions.
