<template>
  <div class="relative" ref="container">
    <!-- Trigger button -->
    <button
      type="button"
      @click="open = !open"
      class="flex items-center gap-2 px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-200 hover:border-indigo-400 transition-colors text-sm w-full"
    >
      <component :is="selectedComponent" v-if="selectedComponent" class="h-5 w-5 text-indigo-600 dark:text-indigo-400 flex-shrink-0" />
      <span v-else class="h-5 w-5 rounded bg-gray-200 dark:bg-gray-700 flex-shrink-0" />
      <span class="flex-1 text-left truncate">{{ modelValue || 'Select an icon…' }}</span>
      <ChevronDownIcon class="h-4 w-4 text-gray-400 flex-shrink-0" />
    </button>

    <!-- Dropdown panel -->
    <teleport to="body">
      <div
        v-if="open"
        :style="panelStyle"
        class="fixed z-50 w-80 bg-white dark:bg-gray-900 rounded-xl shadow-2xl border border-gray-200 dark:border-gray-700 flex flex-col"
        style="max-height: 380px;"
      >
        <!-- Search -->
        <div class="p-2 border-b border-gray-100 dark:border-gray-800 flex-shrink-0">
          <div class="flex items-center gap-2 px-2 py-1.5 rounded-lg bg-gray-100 dark:bg-gray-800">
            <MagnifyingGlassIcon class="h-4 w-4 text-gray-400 flex-shrink-0" />
            <input
              ref="searchInput"
              v-model="query"
              placeholder="Search icons…"
              class="flex-1 bg-transparent text-sm text-gray-800 dark:text-gray-100 outline-none placeholder-gray-400"
            />
            <button v-if="query" type="button" @click="query = ''" class="text-gray-400 hover:text-gray-600">
              <XMarkIcon class="h-3.5 w-3.5" />
            </button>
          </div>
        </div>

        <!-- Icon grid -->
        <div class="overflow-y-auto p-2 flex-1">
          <p v-if="filtered.length === 0" class="text-xs text-gray-400 text-center py-6">No icons found</p>
          <div class="grid grid-cols-8 gap-1">
            <button
              v-for="name in filtered"
              :key="name"
              type="button"
              :title="name.replace(/Icon$/, '')"
              @click="select(name)"
              class="flex items-center justify-center h-8 w-8 rounded-lg transition-colors"
              :class="modelValue === name
                ? 'bg-indigo-100 dark:bg-indigo-900 text-indigo-600 dark:text-indigo-400'
                : 'hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-600 dark:text-gray-400'"
            >
              <component :is="allIcons[name]" class="h-5 w-5" />
            </button>
          </div>
        </div>

        <!-- Clear selection -->
        <div v-if="modelValue" class="p-2 border-t border-gray-100 dark:border-gray-800 flex-shrink-0">
          <button type="button" @click="select('')" class="text-xs text-red-500 hover:underline w-full text-left">
            Clear selection
          </button>
        </div>
      </div>
    </teleport>
  </div>
</template>

<script lang="ts" setup>
import { ref, computed, watch, nextTick, onMounted, onUnmounted } from 'vue';
import * as OutlineIcons from '@heroicons/vue/24/outline';
import { ChevronDownIcon, MagnifyingGlassIcon, XMarkIcon } from '@heroicons/vue/24/outline';

const props = defineProps<{ modelValue: string }>();
const emit = defineEmits<{ (e: 'update:modelValue', value: string): void }>();

// All icon names (excludes re-exported helpers that aren't components)
const allIcons = OutlineIcons as Record<string, any>;
const allNames: string[] = Object.keys(allIcons).filter(k => k.endsWith('Icon'));

const open = ref(false);
const query = ref('');
const container = ref<HTMLElement | null>(null);
const searchInput = ref<HTMLInputElement | null>(null);
const panelStyle = ref<Record<string, string>>({});

const filtered = computed(() => {
  if (!query.value) return allNames;
  const q = query.value.toLowerCase().replace(/\s+/g, '');
  return allNames.filter(n => n.toLowerCase().replace('icon', '').includes(q));
});

const selectedComponent = computed(() =>
  props.modelValue ? allIcons[props.modelValue] ?? null : null
);

function select(name: string) {
  emit('update:modelValue', name);
  open.value = false;
  query.value = '';
}

function positionPanel() {
  if (!container.value) return;
  const rect = container.value.getBoundingClientRect();
  const spaceBelow = window.innerHeight - rect.bottom;
  const top = spaceBelow > 390 ? rect.bottom + 4 : rect.top - 384;
  panelStyle.value = {
    top: `${top}px`,
    left: `${Math.min(rect.left, window.innerWidth - 320 - 8)}px`,
  };
}

watch(open, async (val) => {
  if (val) {
    positionPanel();
    await nextTick();
    searchInput.value?.focus();
  }
});

function onClickOutside(e: MouseEvent) {
  if (!open.value) return;
  const target = e.target as Node;
  if (container.value && container.value.contains(target)) return;
  // Check if click is inside the teleported panel
  const panel = document.querySelector('.fixed.z-50.w-80');
  if (panel && panel.contains(target)) return;
  open.value = false;
}

onMounted(() => document.addEventListener('mousedown', onClickOutside));
onUnmounted(() => document.removeEventListener('mousedown', onClickOutside));
</script>
