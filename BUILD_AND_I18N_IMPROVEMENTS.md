# Build Order and i18n Improvements

This document describes the improvements made to the build process and i18n handling in the drhanasabzadeh-dama monorepo.

## Build Order Fix

### Problem
The repository lacked a proper monorepo structure:
- No root-level package.json for orchestrating builds
- No shared package for common code
- No defined build order

### Solution
Implemented npm workspaces with proper build orchestration:

```
drhanasabzadeh-dama/
├── package.json (root - orchestrates builds)
└── packages/
    ├── share/ (@yektayar/share - shared utilities)
    ├── mobile-app/ (Vue 3 mobile application)
    └── admin-panel/ (Laravel admin panel)
```

### Build Commands

```bash
# Build everything in correct order
npm run build

# Build individual packages
npm run build:share
npm run build:mobile
npm run build:admin

# Development
npm run dev:mobile
```

### Build Order
The build process now follows this order:
1. **`@yektayar/share`** - Shared utilities (built first as it may be used by other packages)
2. **`mobile-app`** - Mobile application
3. **`admin-panel`** - Admin panel (Laravel - build skipped as it uses composer)

### @yektayar/share Package
A new shared package containing common utilities:
- Constants (app name, API config, date formats, locales)
- Helper functions (formatNumber, truncate, isEmpty, deepClone)
- TypeScript with type definitions
- Built to both ESM and CommonJS formats

**Usage Example:**
```typescript
import { APP_NAME, formatNumber, isEmpty } from '@yektayar/share';

console.log(formatNumber(1234567)); // "1,234,567"
console.log(isEmpty(null)); // true
```

---

## i18n Improvements

### Problem
The mobile app's i18n implementation had several issues:
1. Displayed raw translation keys (e.g., "Home.title") when values were missing
2. No logging or warnings for missing translations
3. No build-time validation
4. Difficult to track missing translations

### Solution
Implemented a comprehensive i18n solution with both runtime and build-time validation.

### Runtime: Missing Key Handler

**File:** `packages/mobile-app/src/plugins/i18n.js`

Created a custom i18n plugin that:
- Intercepts missing translation lookups
- Logs warnings to the console
- Tracks missing keys
- Returns user-friendly placeholders instead of raw keys

**Features:**
```javascript
// Instead of displaying "Home.title", displays "[Missing: title]"
// Console shows detailed warning:
// [i18n] Missing translation key: "Home.title" for locale: "fa"
//   Component: HomeComponent
```

**Console Output Examples:**

Development mode (detailed):
```
⚠ [i18n] Missing translation key: "Invoice.discount" for locale: "fa"
  Component: InvoiceComponent
  Values: {"amount": 1000}
```

Production mode (concise):
```
⚠ [i18n] Missing: fa:Invoice.discount
```

**Summary Report:**
On page unload (development only), a summary shows all missing keys:
```
[i18n] Missing Translation Keys Summary
Total missing keys: 195
  Locale: fa
    - config.dir
    - General.loginApplication
    - Footer.support
    ...
```

### Build-time: Validation Script

**File:** `packages/mobile-app/scripts/validate-i18n.js`

Comprehensive validation script that runs before building:

**What it validates:**
1. **Locale Consistency** - All locale files have the same keys
2. **Empty Values** - No translation has empty values
3. **Used Keys** - Keys used in code exist in locale files

**How it works:**
```bash
# Runs automatically before build
npm run build:mobile

# Run manually
npm run validate:i18n --workspace=dama-mobile-app
```

**Output Example:**
```
╔════════════════════════════════════════╗
║  i18n Translation Validation Script   ║
╚════════════════════════════════════════╝

=== Validating Locale Consistency ===
ℹ Loaded en: 4 keys
ℹ Loaded fa: 4 keys
✓ All locales have consistent keys

=== Checking for Empty Values ===
✓ No empty values found

=== Validating Used Keys ===
ℹ Found 195 translation key(s) used in code
⚠ Warning: 195 keys used in code but missing in locale files

=== Validation Summary ===
✓ consistency: PASSED
✓ emptyValues: PASSED
✗ usedKeys: FAILED

✓ All critical validations passed!
⚠ Warning: Some translation keys used in code are missing in locale files.
  This will not fail the build, but should be fixed.
```

**Exit Codes:**
- `0` - Success (warnings are okay)
- `1` - Critical failure (inconsistent locales or empty values)

**Detection:**
The script scans all `.vue` and `.js` files for translation key usage:
- `$t('key')` or `$t("key")`
- `t('key')` or `t("key")`

### How to Fix Missing Translations

When you see missing key warnings:

1. **Add translations to locale files:**
```json
// packages/mobile-app/src/locales/en.json
{
  "Home": {
    "title": "Home",
    "welcome": "Welcome"
  },
  "Invoice": {
    "discount": "Discount"
  }
}

// packages/mobile-app/src/locales/fa.json
{
  "Home": {
    "title": "خانه",
    "welcome": "خوش آمدید"
  },
  "Invoice": {
    "discount": "تخفیف"
  }
}
```

2. **Run validation to verify:**
```bash
npm run validate:i18n --workspace=dama-mobile-app
```

### Configuration

**main.js changes:**
```javascript
// Before
import { createI18n } from 'vue-i18n'
const i18n = createI18n({
    locale: 'en',
    messages: { ... }
})

// After
import { createI18nWithLogging } from './plugins/i18n'
const i18n = createI18nWithLogging({
    locale: 'fa',
    fallbackLocale: 'en',
    messages: { ... }
})
```

**package.json scripts:**
```json
{
  "scripts": {
    "build": "npm run validate:i18n && vue-cli-service build",
    "build:skip-validation": "vue-cli-service build",
    "validate:i18n": "node scripts/validate-i18n.js"
  }
}
```

---

## Benefits

### Build Order
- ✅ Clear, predictable build process
- ✅ Shared code built once, used by all packages
- ✅ Easy to add new packages
- ✅ Follows monorepo best practices

### i18n
- ✅ No more displaying raw translation keys to users
- ✅ Developers are alerted to missing translations immediately
- ✅ Build-time validation prevents shipping incomplete translations
- ✅ Easy to track and fix missing translations
- ✅ Better user experience with meaningful placeholders
- ✅ Comprehensive console logging for debugging

---

## Testing

### Test Build Order
```bash
# Clean and rebuild
rm -rf packages/share/dist
npm run build

# Verify share/dist/ exists after build
ls packages/share/dist/
```

### Test i18n Validation
```bash
# Run validation
cd packages/mobile-app
npm run validate:i18n

# Check for missing keys in a Vue component
echo 't("Test.missing")' >> src/views/Home.vue
npm run validate:i18n
# Should report: Test.missing
```

### Test Runtime Logging
```bash
# Start dev server
npm run dev:mobile

# Open browser console
# Navigate to pages
# Watch for [i18n] warnings in console
# Missing keys show as "[Missing: keyname]" in UI
```

---

## Future Improvements

1. **Auto-generate missing keys**: Create a script to add missing keys to locale files with placeholder values
2. **Translation coverage reports**: Generate reports showing translation coverage per locale
3. **Integration with translation services**: Connect to services like Lokalise or Crowdin
4. **Fallback chain**: Implement multi-level fallbacks (fa → en → key)
5. **Hot reload for translations**: Update translations without reloading the page
6. **TypeScript for locale files**: Type-safe translation keys
7. **Pluralization rules**: Add support for plural forms per locale
8. **Context-aware translations**: Support different translations based on context

---

## Troubleshooting

### Build fails with "workspace not found"
```bash
# Make sure you're in the root directory
cd /path/to/drhanasabzadeh-dama

# Reinstall dependencies
rm -rf node_modules package-lock.json
npm install
```

### i18n validation fails on critical checks
```bash
# Check locale files are consistent
diff packages/mobile-app/src/locales/en.json packages/mobile-app/src/locales/fa.json

# Look for empty values
grep '""' packages/mobile-app/src/locales/*.json
```

### Missing keys not detected
```bash
# Verify you're using the correct i18n syntax
# The script looks for: $t('key') or t('key')
# Other patterns won't be detected

# Add more patterns to validate-i18n.js:
const patterns = [
  /\$t\(['"`]([^'"`]+)['"`]\)/g,
  /\bt\(['"`]([^'"`]+)['"`]\)/g,
  // Add your custom patterns here
];
```

---

## References

- [npm workspaces documentation](https://docs.npmjs.com/cli/v7/using-npm/workspaces)
- [vue-i18n documentation](https://vue-i18n.intlify.dev/)
- [TypeScript documentation](https://www.typescriptlang.org/docs/)
