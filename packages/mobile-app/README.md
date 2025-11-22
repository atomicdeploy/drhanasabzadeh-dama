# Dama Mobile App

Vue3-based mobile application for Dr. Hana Sabzadeh's platform.

## About

This is the mobile-app package extracted from the legacy production deployment at https://drhanasabzadeh.ir/

The source code was reconstructed from the production build using source maps available at the live site.

## Project Structure

```
packages/mobile-app/
├── src/
│   ├── components/     # Reusable Vue components
│   ├── views/          # Page components
│   ├── router/         # Vue Router configuration
│   ├── stores/         # Pinia state management
│   ├── locales/        # i18n translation files
│   ├── App.vue         # Root component
│   └── main.js         # Application entry point
├── public/
│   ├── constant.json   # Application configuration
│   ├── favicon.png     # Application icon
│   └── index.html      # HTML template
├── package.json
└── vue.config.js
```

## Technology Stack

- **Vue 3** - Progressive JavaScript framework
- **Vue Router 4** - Official router for Vue.js
- **Pinia** - Vue store (state management)
- **Vuestic UI** - Vue 3 UI framework
- **Vue I18n** - Internationalization plugin
- **Axios** - HTTP client
- **Vue Video Player** - Video playback component
- **SweetAlert2** - Beautiful popups

## Setup

```bash
# Install dependencies
npm install

# Run development server
npm run serve

# Build for production
npm run build

# Lint and fix files
npm run lint
```

## Configuration

The application reads its configuration from `public/constant.json` which contains:
- Base API URL
- App name and branding
- Theme colors
- Push notification settings
- Other app-specific settings

## Development

The app was originally built with Vue CLI. The source maps enabled reconstruction of the original source code structure.

## Notes

- This is a 1:1 replica of the legacy codebase
- Locale files (en.json, fa.json) are placeholders and need to be populated with actual translations
- Future improvements and refactoring will be done in subsequent PRs
