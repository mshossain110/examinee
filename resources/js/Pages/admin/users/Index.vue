<template>
  <AdminLayout>
    <div id="users">
      <Card class="mb-5">
        <h1 class="text-lg font-semibold">Users</h1>
        <Breadcrumb :items="breadcrumb" />
      </Card>

      <Card>
        <!-- Filter bar -->
        <div class="w-full flex flex-col sm:flex-row gap-2 mb-6">
          <!-- Search -->
          <div class="flex-1 relative sm:w-44">
            <MagnifyingGlassIcon class="absolute left-2.5 top-1/2 -translate-y-1/2 h-3.5 w-3.5 text-indigo-400 dark:text-indigo-300 pointer-events-none" />
            <input
              type="text"
              :value="filters.search"
              @input="onSearch"
              placeholder="Search by name or email…"
              class="w-full pl-8 pr-3 py-1.5 text-xs bg-white dark:bg-gray-800 dark:text-gray-100 border border-indigo-200 dark:border-indigo-700 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 placeholder-gray-400 dark:placeholder-gray-500"
            />
          </div>

          <!-- Role filter -->
          <div class="w-full sm:w-44">
            <select
              :value="filters.role"
              @change="onRoleChange"
              class="w-full text-xs bg-white dark:bg-gray-800 dark:text-gray-100 border border-indigo-200 dark:border-indigo-700 rounded-lg px-2.5 py-1.5 shadow-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
            >
              <option value="">All Roles</option>
              <option v-for="role in roles" :key="role.id" :value="role.name">
                {{ role.name }}
              </option>
            </select>
          </div>

          <!-- Clear filters -->
          <button
            v-if="filters.search || filters.role"
            type="button"
            @click="clearFilters"
            class="flex-shrink-0 inline-flex items-center gap-1 text-xs font-medium text-indigo-600 dark:text-indigo-300 hover:text-white hover:bg-indigo-600 dark:hover:bg-indigo-500 bg-white dark:bg-gray-800 border border-indigo-300 dark:border-indigo-600 rounded-lg px-3 py-1.5 transition-colors shadow-sm"
          >
            <XMarkIcon class="h-3 w-3" />
            Clear
          </button>
        </div>

        <DataTable v-model="selected" :rows="response.data" :columns="columns">
          <template #name-data="{ row }">
            <div class="flex items-center gap-3">
              <img
                class="h-10 w-10 rounded-xl object-cover object-center flex-shrink-0 ring-2 ring-indigo-100"
                alt="Avatar"
                :src="row.avatar?.avatar ?? row.avatar"
              />
              <div>
                <div class="font-semibold text-indigo-700 hover:text-indigo-900 transition-colors">{{ row.full_name }}</div>
                <div class="text-xs text-gray-400 mt-0.5">{{ row.email }}</div>
              </div>
            </div>
          </template>

          <!-- Role column with assign icon -->
          <template #roles.0.name-data="{ row }">
            <div class="flex items-center gap-2">
              <span
                v-if="row.roles && row.roles.length"
                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-indigo-100 dark:bg-indigo-900 text-indigo-700 dark:text-indigo-300"
              >
                {{ row.roles[0].name }}
                <span v-if="row.roles.length > 1" class="text-indigo-400">+{{ row.roles.length - 1 }}</span>
              </span>
              <span v-else class="text-xs text-gray-400 italic">No role</span>

              <button
                type="button"
                title="Manage roles"
                @click="openRoleModal(row)"
                class="flex-shrink-0 p-0.5 rounded text-indigo-400 hover:text-indigo-600 hover:bg-indigo-50 dark:hover:bg-indigo-900 transition-colors"
              >
                <UserGroupIcon class="h-4 w-4" />
              </button>
            </div>
          </template>

          <template #actions-data="{ row }">
            <div class="flex">
              <Link :href="route('admin.users.edit', row)">
                <PencilIcon class="mr-2 h-5 w-5 text-gray-500 hover:text-indigo-600 transition-colors" />
              </Link>
              <Link @click="deleteUser(row)" as="button" href="">
                <TrashIcon class="mr-2 h-5 w-5 text-gray-500 hover:text-red-600 transition-colors" />
              </Link>
            </div>
          </template>
        </DataTable>

        <Pagination :paginate="response.meta" class="justify-end mt-4" />
      </Card>
    </div>

    <!-- Role assignment modal -->
    <teleport to="body">
      <transition
        enter-active-class="transition ease-out duration-200"
        enter-from-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="transition ease-in duration-150"
        leave-from-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-if="roleModal.open" class="fixed inset-0 z-50 flex items-center justify-center p-4">
          <!-- Backdrop -->
          <div class="absolute inset-0 bg-black/50 dark:bg-black/70" @click="closeRoleModal" />

          <!-- Panel -->
          <div class="relative w-full max-w-sm bg-white dark:bg-gray-900 rounded-2xl shadow-2xl ring-1 ring-gray-200 dark:ring-gray-700 overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100 dark:border-gray-800">
              <div>
                <h3 class="text-base font-semibold text-gray-900 dark:text-white">Manage Roles</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ roleModal.user?.full_name }}</p>
              </div>
              <button type="button" @click="closeRoleModal"
                class="p-1.5 rounded-lg text-gray-400 hover:text-gray-600 hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                <XMarkIcon class="h-5 w-5" />
              </button>
            </div>

            <!-- Role list -->
            <div class="px-5 py-4 space-y-2">
              <label
                v-for="role in roles"
                :key="role.id"
                class="flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition-colors"
                :class="selectedRoleIds.includes(role.id)
                  ? 'border-indigo-400 bg-indigo-50 dark:bg-indigo-900/40 dark:border-indigo-600'
                  : 'border-gray-200 dark:border-gray-700 hover:border-indigo-200 dark:hover:border-indigo-700 hover:bg-gray-50 dark:hover:bg-gray-800'"
              >
                <input
                  type="checkbox"
                  :value="role.id"
                  v-model="selectedRoleIds"
                  class="rounded border-gray-300 dark:border-gray-600 text-indigo-600 focus:ring-indigo-500 dark:bg-gray-700"
                />
                <span class="text-sm font-medium text-gray-800 dark:text-gray-200 capitalize">{{ role.name }}</span>
                <span
                  v-if="selectedRoleIds.includes(role.id)"
                  class="ml-auto text-xs text-indigo-600 dark:text-indigo-400 font-medium"
                >Active</span>
              </label>
            </div>

            <!-- Footer -->
            <div class="flex items-center justify-end gap-2 px-5 py-4 border-t border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-800/50">
              <button type="button" @click="closeRoleModal"
                class="text-sm font-medium text-gray-600 dark:text-gray-400 px-4 py-2 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                Cancel
              </button>
              <button type="button" @click="saveRoles" :disabled="savingRoles"
                class="inline-flex items-center gap-1.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 disabled:opacity-60 px-4 py-2 rounded-lg transition-colors shadow-sm">
                <ArrowPathIcon v-if="savingRoles" class="h-4 w-4 animate-spin" />
                Save Roles
              </button>
            </div>
          </div>
        </div>
      </transition>
    </teleport>
  </AdminLayout>
</template>

<script setup lang="ts">
import { ref, computed } from 'vue';
import {
  MagnifyingGlassIcon, TrashIcon, PencilIcon, XMarkIcon,
  UserGroupIcon, ArrowPathIcon,
} from '@heroicons/vue/24/outline';
import { LinkType, JsonResponse, User, Role } from "@/types";
import { Link, router, useForm } from "@inertiajs/vue3";
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Breadcrumb from "@/Components/Breadcrumb.vue";
import DataTable from "@/Components/Datatable/Table.vue";
import Card from '@/Components/Card.vue';
import Pagination from '@/Components/Pagination.vue';

const props = defineProps<{
  response: JsonResponse<User[]>;
  roles: Role[];
  filters: { search?: string; role?: string };
}>();

const selected = ref([]);

const columns = [
  { key: 'name',              label: 'Name' },
  { key: 'roles.0.name',     label: 'Role' },
  { key: 'email_verified_at', label: 'Verified' },
  { key: 'actions' },
];

const breadcrumb = computed<LinkType[]>(() => [
  { name: 'Users', href: route('admin.users.index'), current: route().current('admin.users.index') },
]);

// ── Filters ─────────────────────────────────────────────────
let searchTimer: ReturnType<typeof setTimeout>;
function onSearch(e: Event) {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(() => {
    applyFilters({ search: (e.target as HTMLInputElement).value, role: props.filters.role ?? '' });
  }, 350);
}
function onRoleChange(e: Event) {
  applyFilters({ search: props.filters.search ?? '', role: (e.target as HTMLSelectElement).value });
}
function clearFilters() {
  applyFilters({ search: '', role: '' });
}
function applyFilters(params: Record<string, string>) {
  router.get(route('admin.users.index'), params, {
    preserveState: true,
    preserveScroll: true,
    replace: true,
  });
}

// ── Delete ───────────────────────────────────────────────────
function deleteUser(user: User) {
  if (confirm('Are you sure you want to delete this user?')) {
    router.delete(route('admin.users.destroy', user.id));
  }
}

// ── Role modal ───────────────────────────────────────────────
const roleModal = ref<{ open: boolean; user: User | null }>({ open: false, user: null });
const selectedRoleIds = ref<number[]>([]);
const savingRoles = ref(false);

function openRoleModal(user: User) {
  roleModal.value.user = user;
  selectedRoleIds.value = (user.roles ?? []).map((r: any) => r.id as number);
  roleModal.value.open = true;
}
function closeRoleModal() {
  roleModal.value.open = false;
  roleModal.value.user = null;
}
function saveRoles() {
  const user = roleModal.value.user;
  if (!user) return;
  savingRoles.value = true;
  router.put(
    route('admin.users.sync-roles', user.id),
    { roles: selectedRoleIds.value },
    {
      preserveScroll: true,
      onSuccess: () => { closeRoleModal(); },
      onFinish: () => { savingRoles.value = false; },
    }
  );
}
</script>
