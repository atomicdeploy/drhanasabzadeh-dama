# @yektayar/share

Shared utilities and constants for Dr. Hana Sabzadeh applications.

## Installation

This package is part of the monorepo and will be built automatically.

```bash
npm run build
```

## Usage

```typescript
import { APP_NAME, formatNumber, isEmpty } from '@yektayar/share';

console.log(APP_NAME); // 'Dr. Hana Sabzadeh'
console.log(formatNumber(1234567)); // '1,234,567'
console.log(isEmpty(null)); // true
```

## Development

```bash
npm run dev  # Watch mode for development
npm run build  # Build for production
```
