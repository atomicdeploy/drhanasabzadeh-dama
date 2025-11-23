#!/usr/bin/env node

/**
 * i18n Validation Script
 * 
 * This script validates i18n translation files to ensure:
 * 1. All locales have the same keys
 * 2. No keys are missing values
 * 3. Translation keys used in code exist in locale files
 * 
 * Usage:
 *   node scripts/validate-i18n.js
 * 
 * Exit codes:
 *   0 - Success, no issues found
 *   1 - Validation errors found
 */

const fs = require('fs');
const path = require('path');

// Configuration
const LOCALES_DIR = path.join(__dirname, '../src/locales');
const SUPPORTED_LOCALES = ['en', 'fa'];
const SRC_DIR = path.join(__dirname, '../src');

// Colors for console output
const colors = {
  reset: '\x1b[0m',
  red: '\x1b[31m',
  green: '\x1b[32m',
  yellow: '\x1b[33m',
  blue: '\x1b[34m',
  magenta: '\x1b[35m',
};

function log(message, color = 'reset') {
  console.log(`${colors[color]}${message}${colors.reset}`);
}

function error(message) {
  log(`✗ ${message}`, 'red');
}

function warning(message) {
  log(`⚠ ${message}`, 'yellow');
}

function success(message) {
  log(`✓ ${message}`, 'green');
}

function info(message) {
  log(`ℹ ${message}`, 'blue');
}

/**
 * Load locale file
 */
function loadLocale(locale) {
  const filePath = path.join(LOCALES_DIR, `${locale}.json`);
  if (!fs.existsSync(filePath)) {
    throw new Error(`Locale file not found: ${filePath}`);
  }
  return JSON.parse(fs.readFileSync(filePath, 'utf8'));
}

/**
 * Get all keys from a nested object
 */
function getAllKeys(obj, prefix = '') {
  const keys = [];
  for (const key in obj) {
    const fullKey = prefix ? `${prefix}.${key}` : key;
    if (typeof obj[key] === 'object' && obj[key] !== null) {
      keys.push(...getAllKeys(obj[key], fullKey));
    } else {
      keys.push(fullKey);
    }
  }
  return keys;
}

/**
 * Validate that all locales have the same keys
 */
function validateLocaleConsistency() {
  log('\n=== Validating Locale Consistency ===', 'blue');
  
  const locales = {};
  const allKeys = new Set();
  
  // Load all locales
  SUPPORTED_LOCALES.forEach(locale => {
    try {
      locales[locale] = loadLocale(locale);
      const keys = getAllKeys(locales[locale]);
      keys.forEach(key => allKeys.add(key));
      info(`Loaded ${locale}: ${keys.length} keys`);
    } catch (err) {
      error(`Failed to load ${locale}: ${err.message}`);
      return false;
    }
  });
  
  // Check for missing keys in each locale
  let hasErrors = false;
  SUPPORTED_LOCALES.forEach(locale => {
    const localeKeys = new Set(getAllKeys(locales[locale]));
    const missingKeys = [...allKeys].filter(key => !localeKeys.has(key));
    
    if (missingKeys.length > 0) {
      hasErrors = true;
      error(`\nLocale "${locale}" is missing ${missingKeys.length} key(s):`);
      missingKeys.forEach(key => console.log(`  - ${key}`));
    }
  });
  
  if (!hasErrors) {
    success('All locales have consistent keys');
  }
  
  return !hasErrors;
}

/**
 * Check for empty values in translations
 */
function validateEmptyValues() {
  log('\n=== Checking for Empty Values ===', 'blue');
  
  let hasWarnings = false;
  
  SUPPORTED_LOCALES.forEach(locale => {
    const data = loadLocale(locale);
    const keys = getAllKeys(data);
    const emptyKeys = [];
    
    keys.forEach(key => {
      const value = key.split('.').reduce((obj, k) => obj[k], data);
      if (!value || value.trim() === '') {
        emptyKeys.push(key);
      }
    });
    
    if (emptyKeys.length > 0) {
      hasWarnings = true;
      warning(`\nLocale "${locale}" has ${emptyKeys.length} empty value(s):`);
      emptyKeys.forEach(key => console.log(`  - ${key}`));
    }
  });
  
  if (!hasWarnings) {
    success('No empty values found');
  }
  
  return !hasWarnings;
}

/**
 * Find translation keys used in source code
 */
function findUsedKeys() {
  log('\n=== Finding Used Translation Keys ===', 'blue');
  
  const usedKeys = new Set();
  
  // Regex patterns to find translation keys
  // Matches: $t('key'), $t("key"), t('key'), t("key")
  const patterns = [
    /\$t\(['"`]([^'"`]+)['"`]\)/g,
    /\bt\(['"`]([^'"`]+)['"`]\)/g,
  ];
  
  function searchDirectory(dir) {
    const files = fs.readdirSync(dir);
    
    files.forEach(file => {
      const filePath = path.join(dir, file);
      const stat = fs.statSync(filePath);
      
      if (stat.isDirectory()) {
        searchDirectory(filePath);
      } else if (file.endsWith('.vue') || file.endsWith('.js')) {
        const content = fs.readFileSync(filePath, 'utf8');
        patterns.forEach(pattern => {
          let match;
          while ((match = pattern.exec(content)) !== null) {
            usedKeys.add(match[1]);
          }
        });
      }
    });
  }
  
  searchDirectory(SRC_DIR);
  
  info(`Found ${usedKeys.size} translation key(s) used in code`);
  return usedKeys;
}

/**
 * Validate that all used keys exist in locale files
 */
function validateUsedKeys() {
  log('\n=== Validating Used Keys ===', 'blue');
  
  const usedKeys = findUsedKeys();
  const baseLocale = loadLocale(SUPPORTED_LOCALES[0]);
  const availableKeys = new Set(getAllKeys(baseLocale));
  
  const missingKeys = [...usedKeys].filter(key => !availableKeys.has(key));
  
  if (missingKeys.length > 0) {
    error(`\nFound ${missingKeys.length} key(s) used in code but missing in locale files:`);
    missingKeys.forEach(key => console.log(`  - ${key}`));
    return false;
  }
  
  success('All used keys exist in locale files');
  return true;
}

/**
 * Main validation function
 */
function main() {
  log('\n╔════════════════════════════════════════╗', 'magenta');
  log('║  i18n Translation Validation Script   ║', 'magenta');
  log('╚════════════════════════════════════════╝', 'magenta');
  
  const results = {
    consistency: validateLocaleConsistency(),
    emptyValues: validateEmptyValues(),
    usedKeys: validateUsedKeys(),
  };
  
  log('\n=== Validation Summary ===', 'blue');
  Object.entries(results).forEach(([check, passed]) => {
    if (passed) {
      success(`${check}: PASSED`);
    } else {
      error(`${check}: FAILED`);
    }
  });
  
  // Only fail on critical issues (consistency and empty values)
  // Missing used keys are warnings only
  const criticalPassed = results.consistency && results.emptyValues;
  
  if (criticalPassed) {
    log('\n✓ All critical validations passed!', 'green');
    if (!results.usedKeys) {
      warning('⚠ Warning: Some translation keys used in code are missing in locale files.');
      warning('  This will not fail the build, but should be fixed.');
    }
    process.exit(0);
  } else {
    log('\n✗ Critical validations failed. Please fix the issues above.', 'red');
    process.exit(1);
  }
}

// Run validation
if (require.main === module) {
  try {
    main();
  } catch (err) {
    error(`\nValidation script failed: ${err.message}`);
    console.error(err);
    process.exit(1);
  }
}

module.exports = {
  loadLocale,
  getAllKeys,
  validateLocaleConsistency,
  validateEmptyValues,
  findUsedKeys,
  validateUsedKeys,
};
