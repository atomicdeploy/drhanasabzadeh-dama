/**
 * Shared helper functions
 */

/**
 * Format a number with thousand separators
 */
export function formatNumber(num: number, locale: string = 'en'): string {
  return new Intl.NumberFormat(locale).format(num);
}

/**
 * Truncate text with ellipsis
 */
export function truncate(text: string, maxLength: number): string {
  if (text.length <= maxLength) return text;
  return text.substring(0, maxLength) + '...';
}

/**
 * Check if a value is empty (null, undefined, empty string, empty array, empty object)
 */
export function isEmpty(value: unknown): boolean {
  if (value === null || value === undefined) return true;
  if (typeof value === 'string') return value.trim().length === 0;
  if (Array.isArray(value)) return value.length === 0;
  if (typeof value === 'object') return Object.keys(value).length === 0;
  return false;
}

/**
 * Deep clone an object
 * Note: This uses JSON serialization which has limitations:
 * - Does not handle functions, undefined, symbols, or circular references
 * - Loses Date objects, RegExp, Map, Set, etc.
 * For complex objects, consider using a library like lodash.cloneDeep
 */
export function deepClone<T>(obj: T): T {
  if (obj === null || typeof obj !== 'object') return obj;
  return JSON.parse(JSON.stringify(obj));
}
