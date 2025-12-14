<template>
  <Teleport to="body">
    <Transition name="fade">
      <div v-if="open" class="fixed inset-0 bg-black/50 z-50" @click="close"></div>
    </Transition>
    <Transition name="scale">
      <div
        v-if="open"
        class="fixed inset-x-4 top-[20%] mx-auto max-w-xl bg-white rounded-xl shadow-2xl z-50 overflow-hidden"
      >
        <div class="border-b">
          <div class="flex items-center px-4">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input
              ref="inputRef"
              v-model="search"
              type="text"
              placeholder="Type a command or search..."
              class="w-full px-4 py-4 text-gray-900 placeholder-gray-400 focus:outline-none"
              @keydown.arrow-down.prevent="selectNext"
              @keydown.arrow-up.prevent="selectPrevious"
              @keydown.enter.prevent="executeSelected"
            >
          </div>
        </div>

        <div class="max-h-80 overflow-y-auto p-2">
          <template v-if="filteredCommands.length">
            <button
              v-for="(command, index) in filteredCommands"
              :key="command.id || index"
              @click="execute(command)"
              @mouseenter="selectedIndex = index"
              :class="['w-full flex items-center gap-3 px-4 py-3 rounded-lg text-left transition-colors', selectedIndex === index ? 'bg-blue-50 text-blue-900' : 'hover:bg-gray-50']"
            >
              <span v-if="command.icon" class="text-gray-400" v-html="command.icon"></span>
              <div>
                <div class="font-medium">{{ command.label }}</div>
                <div v-if="command.description" class="text-sm text-gray-500">{{ command.description }}</div>
              </div>
              <kbd v-if="command.shortcut" class="ml-auto px-2 py-1 text-xs bg-gray-100 rounded">{{ command.shortcut }}</kbd>
            </button>
          </template>
          <div v-else class="px-4 py-8 text-center text-gray-500">No commands found</div>
        </div>

        <div class="border-t px-4 py-2 text-xs text-gray-400 flex items-center gap-4">
          <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded">↑↓</kbd> Navigate</span>
          <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded">↵</kbd> Select</span>
          <span><kbd class="px-1.5 py-0.5 bg-gray-100 rounded">esc</kbd> Close</span>
        </div>
      </div>
    </Transition>
  </Teleport>
</template>

<script>
import { ref, computed, watch, onMounted, onUnmounted, nextTick } from 'vue';

export default {
  name: 'LdCommandPalette',
  props: {
    commands: { type: Array, default: () => [] },
    placeholder: { type: String, default: 'Type a command or search...' }
  },
  emits: ['execute'],
  setup(props, { emit, expose }) {
    const open = ref(false);
    const search = ref('');
    const selectedIndex = ref(0);
    const inputRef = ref(null);

    const filteredCommands = computed(() => {
      if (!search.value) return props.commands;
      const q = search.value.toLowerCase();
      return props.commands.filter(cmd =>
        cmd.label.toLowerCase().includes(q) ||
        (cmd.keywords && cmd.keywords.some(k => k.toLowerCase().includes(q)))
      );
    });

    watch(search, () => { selectedIndex.value = 0; });
    watch(open, (val) => {
      if (val) nextTick(() => inputRef.value?.focus());
      else { search.value = ''; selectedIndex.value = 0; }
    });

    const toggle = () => { open.value = !open.value; };
    const close = () => { open.value = false; };
    const selectNext = () => { selectedIndex.value = Math.min(selectedIndex.value + 1, filteredCommands.value.length - 1); };
    const selectPrevious = () => { selectedIndex.value = Math.max(selectedIndex.value - 1, 0); };
    const execute = (cmd) => { emit('execute', cmd); close(); };
    const executeSelected = () => {
      if (filteredCommands.value[selectedIndex.value]) {
        execute(filteredCommands.value[selectedIndex.value]);
      }
    };

    const handleKeydown = (e) => {
      if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        toggle();
      }
      if (e.key === 'Escape' && open.value) close();
    };

    onMounted(() => document.addEventListener('keydown', handleKeydown));
    onUnmounted(() => document.removeEventListener('keydown', handleKeydown));

    expose({ open: toggle, close });

    return { open, search, selectedIndex, inputRef, filteredCommands, close, selectNext, selectPrevious, execute, executeSelected };
  }
};
</script>

<style scoped>
.fade-enter-active, .fade-leave-active { transition: opacity 0.2s ease; }
.fade-enter-from, .fade-leave-to { opacity: 0; }
.scale-enter-active, .scale-leave-active { transition: all 0.2s ease; }
.scale-enter-from, .scale-leave-to { opacity: 0; transform: scale(0.95); }
</style>
