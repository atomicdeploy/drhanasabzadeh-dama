/**
 * i18n Plugin with missing key detection and logging
 * 
 * This plugin enhances vue-i18n to:
 * 1. Log missing translation keys to console with warnings
 * 2. Return a placeholder instead of the key itself
 * 3. Track missing keys for build-time validation
 */

import { createI18n } from 'vue-i18n';

// Track missing keys
const missingKeys = new Set();

/**
 * Get missing keys that have been tracked
 */
export function getMissingKeys() {
  return Array.from(missingKeys);
}

/**
 * Clear tracked missing keys
 */
export function clearMissingKeys() {
  missingKeys.clear();
}

/**
 * Create i18n instance with missing key handler
 */
export function createI18nWithLogging(options) {
  const i18n = createI18n({
    legacy: false,
    locale: options.locale || 'en',
    fallbackLocale: options.fallbackLocale || 'en',
    messages: options.messages || {},
    silentTranslationWarn: false,
    silentFallbackWarn: false,
    missing: (locale, key, vm, values) => {
      // Track this missing key
      const missingKeyInfo = `${locale}:${key}`;
      if (!missingKeys.has(missingKeyInfo)) {
        missingKeys.add(missingKeyInfo);
        
        // Log warning to console
        if (process.env.NODE_ENV === 'development') {
          console.warn(
            `[i18n] Missing translation key: "${key}" for locale: "${locale}"`,
            vm ? `\nComponent: ${vm.$options.name || 'Anonymous'}` : '',
            values ? `\nValues: ${JSON.stringify(values)}` : ''
          );
        } else {
          // In production, use less verbose logging
          console.warn(`[i18n] Missing: ${locale}:${key}`);
        }
      }
      
      // Return a placeholder instead of the key
      // Format: [Missing: key]
      return `[Missing: ${key.split('.').pop()}]`;
    },
    missingWarn: process.env.NODE_ENV === 'development',
    fallbackWarn: process.env.NODE_ENV === 'development'
  });

  return i18n;
}

/**
 * Log summary of missing keys (useful for debugging)
 */
export function logMissingKeysSummary() {
  const keys = getMissingKeys();
  if (keys.length > 0) {
    console.group('%c[i18n] Missing Translation Keys Summary', 'color: orange; font-weight: bold');
    console.log(`Total missing keys: ${keys.length}`);
    
    // Group by locale
    const byLocale = {};
    keys.forEach(keyInfo => {
      const [locale, key] = keyInfo.split(':');
      if (!byLocale[locale]) byLocale[locale] = [];
      byLocale[locale].push(key);
    });
    
    Object.keys(byLocale).forEach(locale => {
      console.group(`Locale: ${locale}`);
      byLocale[locale].forEach(key => console.log(`  - ${key}`));
      console.groupEnd();
    });
    
    console.groupEnd();
  }
}

// Log summary when page unloads (in development)
if (process.env.NODE_ENV === 'development' && typeof window !== 'undefined') {
  window.addEventListener('beforeunload', () => {
    logMissingKeysSummary();
  });
}
