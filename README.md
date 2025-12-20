# Command Palette

A Cmd+K style command palette for Laravel applications. Quick access to actions and navigation. Works with Livewire and Vue 3.

## Installation

```bash
composer require mrshanebarron/command-palette
```

## Livewire Usage

### Basic Usage

```blade
<livewire:sb-command-palette :commands="[
    ['label' => 'Go to Dashboard', 'action' => '/dashboard', 'icon' => 'home'],
    ['label' => 'Create New Post', 'action' => '/posts/create', 'icon' => 'plus'],
    ['label' => 'View Profile', 'action' => '/profile', 'icon' => 'user']
]" />
```

### With Groups

```blade
<livewire:sb-command-palette :commands="[
    ['group' => 'Navigation', 'label' => 'Dashboard', 'action' => '/dashboard'],
    ['group' => 'Navigation', 'label' => 'Settings', 'action' => '/settings'],
    ['group' => 'Actions', 'label' => 'New Post', 'action' => 'createPost'],
    ['group' => 'Actions', 'label' => 'New User', 'action' => 'createUser']
]" />
```

### Livewire Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `commands` | array | `[]` | Available commands |
| `placeholder` | string | `'Type a command...'` | Search placeholder |
| `shortcut` | string | `'k'` | Keyboard shortcut key |

## Vue 3 Usage

### Setup

```javascript
import { SbCommandPalette } from './vendor/sb-command-palette';
app.component('SbCommandPalette', SbCommandPalette);
```

### Basic Usage

```vue
<template>
  <SbCommandPalette :commands="commands" @select="handleCommand" />
</template>

<script setup>
const commands = [
  { id: 'dashboard', label: 'Go to Dashboard', icon: 'home' },
  { id: 'new-post', label: 'Create New Post', icon: 'plus' },
  { id: 'settings', label: 'Open Settings', icon: 'cog' }
];

const handleCommand = (command) => {
  console.log('Selected:', command);
};
</script>
```

### With Groups

```vue
<template>
  <SbCommandPalette :commands="commands" @select="handleCommand" />
</template>

<script setup>
const commands = [
  { group: 'Navigation', id: 'home', label: 'Home', action: '/' },
  { group: 'Navigation', id: 'dashboard', label: 'Dashboard', action: '/dashboard' },
  { group: 'Actions', id: 'new', label: 'Create New...', shortcut: 'N' },
  { group: 'Actions', id: 'search', label: 'Search', shortcut: '/' }
];
</script>
```

### With Keyboard Shortcuts

```vue
<template>
  <SbCommandPalette :commands="commands" />
</template>

<script setup>
const commands = [
  { id: 'save', label: 'Save', shortcut: 'Cmd+S' },
  { id: 'undo', label: 'Undo', shortcut: 'Cmd+Z' },
  { id: 'search', label: 'Search', shortcut: '/' }
];
</script>
```

### Dynamic Commands

```vue
<template>
  <SbCommandPalette
    :commands="filteredCommands"
    @search="handleSearch"
  />
</template>

<script setup>
import { ref, computed } from 'vue';

const searchQuery = ref('');
const allCommands = [...];

const filteredCommands = computed(() => {
  if (!searchQuery.value) return allCommands;
  return allCommands.filter(cmd =>
    cmd.label.toLowerCase().includes(searchQuery.value.toLowerCase())
  );
});

const handleSearch = (query) => {
  searchQuery.value = query;
};
</script>
```

### Vue Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `commands` | Array | `[]` | Command list |
| `placeholder` | String | `'Type a command...'` | Input placeholder |
| `shortcut` | String | `'k'` | Trigger key (with Cmd/Ctrl) |

### Events

| Event | Payload | Description |
|-------|---------|-------------|
| `select` | `command` | Command selected |
| `search` | `query` | Search input changed |
| `open` | - | Palette opened |
| `close` | - | Palette closed |

## Command Object

```javascript
{
  id: 'unique-id',       // Required
  label: 'Command Name', // Required
  group: 'Group Name',   // Optional grouping
  icon: 'icon-name',     // Optional icon
  shortcut: 'Cmd+K',     // Optional shortcut display
  action: '/path',       // URL or action identifier
  disabled: false        // Optional disabled state
}
```

## Features

- **Cmd+K Trigger**: Opens with keyboard shortcut
- **Search**: Filter commands by typing
- **Groups**: Organize commands by category
- **Shortcuts**: Display keyboard shortcuts
- **Keyboard Navigation**: Arrow keys + Enter

## Keyboard Shortcuts

| Key | Action |
|-----|--------|
| `Cmd/Ctrl+K` | Open palette |
| `Escape` | Close palette |
| `↑/↓` | Navigate items |
| `Enter` | Select item |

## Styling

Uses Tailwind CSS:
- Centered modal overlay
- Search input at top
- Grouped results
- Highlighted selection

## Requirements

- PHP 8.1+
- Laravel 10, 11, or 12
- Tailwind CSS 3.x

## License

MIT License
