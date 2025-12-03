/**
 * Shared constants across applications
 */

export const APP_NAME = 'Dr. Hana Sabzadeh';
export const APP_VERSION = '1.0.0';

// API Configuration
export const API_TIMEOUT = 30000;
export const API_RETRY_COUNT = 3;

// Date formats
export const DATE_FORMAT = 'YYYY-MM-DD';
export const DATETIME_FORMAT = 'YYYY-MM-DD HH:mm:ss';

// Locale constants
export const DEFAULT_LOCALE = 'fa';
export const SUPPORTED_LOCALES = ['fa', 'en'] as const;
export type SupportedLocale = typeof SUPPORTED_LOCALES[number];
