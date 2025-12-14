# Laravel Design Command Palette

Cmd+K command palette component for Laravel. Supports Livewire, Blade, and Vue 3.

## Installation

```bash
composer require mrshanebarron/command-palette
```

## Usage

### Livewire Component

```blade
<livewire:ld-command-palette />
```

### Blade Component

```blade
<x-ld-command-palette />
```

## Configuration

Publish the config file:

```bash
php artisan vendor:publish --tag=ld-command-palette-config
```

## Customization

### Publishing Views

```bash
php artisan vendor:publish --tag=ld-command-palette-views
```

## License

MIT
