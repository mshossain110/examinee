<script setup lang="ts">
import { computed, ref, watch } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import { Role } from "@/types";
import { useForm, usePage } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";
import { CheckCircleIcon, XMarkIcon } from "@heroicons/vue/24/outline";

interface Permission {
    id: number;
    name: string;
}

const props = defineProps<{
    role: Role;
    permissions: Permission[];
}>();

const page = usePage();
const flashProp = computed(() => (page.props as any).flash as { success?: string; error?: string } | undefined);

// Local dismissible state
const showToast = ref(false);
const toastMessage = ref('');
const toastType = ref<'success' | 'error'>('success');
let toastTimer: ReturnType<typeof setTimeout>;

watch(flashProp, (f) => {
    if (f?.success) {
        toastMessage.value = f.success;
        toastType.value = 'success';
        showToast.value = true;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { showToast.value = false; }, 4000);
    } else if (f?.error) {
        toastMessage.value = f.error;
        toastType.value = 'error';
        showToast.value = true;
        clearTimeout(toastTimer);
        toastTimer = setTimeout(() => { showToast.value = false; }, 5000);
    }
}, { immediate: true });

// Pre-select the role's current permission IDs
const currentPermissionIds: number[] = (props.role.permissions ?? []).map((p: any) => p.id as number);

const roleForm = useForm({
    name: props.role.name,
    permissions: currentPermissionIds,
});

// Group permissions by prefix
const groupedPermissions = computed(() => {
    const groups: Record<string, Permission[]> = {};
    for (const perm of props.permissions) {
        const group = perm.name.split('.')[0].trim();
        if (!groups[group]) groups[group] = [];
        groups[group].push(perm);
    }
    return groups;
});

function groupAllChecked(perms: Permission[]): boolean {
    return perms.every((p) => roleForm.permissions.includes(p.id));
}

function toggleAll(perms: Permission[], checked: boolean) {
    perms.forEach((p) => {
        if (checked && !roleForm.permissions.includes(p.id)) {
            roleForm.permissions.push(p.id);
        } else if (!checked) {
            roleForm.permissions = roleForm.permissions.filter((id) => id !== p.id);
        }
    });
}

function submit() {
    roleForm.put(route("admin.roles.update", props.role.id));
}
</script>

<template>
    <AdminLayout>
        <div id="edit-role">
            <!-- Toast notification -->
            <transition
                enter-active-class="transition ease-out duration-300"
                enter-from-class="opacity-0 -translate-y-3"
                enter-to-class="opacity-100 translate-y-0"
                leave-active-class="transition ease-in duration-200"
                leave-from-class="opacity-100 translate-y-0"
                leave-to-class="opacity-0 -translate-y-3"
            >
                <div
                    v-if="showToast"
                    :class="[
                        'flex items-start gap-3 mb-4 px-4 py-3 rounded-xl border shadow-sm',
                        toastType === 'success'
                            ? 'bg-green-50 border-green-200 text-green-800'
                            : 'bg-red-50 border-red-200 text-red-800',
                    ]"
                >
                    <CheckCircleIcon v-if="toastType === 'success'" class="h-5 w-5 flex-shrink-0 text-green-500 mt-0.5" />
                    <span class="flex-1 text-sm font-medium">{{ toastMessage }}</span>
                    <button type="button" @click="showToast = false" class="flex-shrink-0 opacity-60 hover:opacity-100 transition-opacity">
                        <XMarkIcon class="h-4 w-4" />
                    </button>
                </div>
            </transition>

            <Card>
                <template #header>
                    <h1 class="text-lg font-semibold">Edit Role</h1>
                </template>

                <!-- Flash success -->
                <!-- (handled by the toast above) -->

                <form @submit.prevent="submit" class="space-y-6">
                    <!-- Role name -->
                    <div class="max-w-sm">
                        <Label label="Role Name" name="name" :error="roleForm.errors.name">
                            <Input v-model="roleForm.name" required />
                        </Label>
                    </div>

                    <!-- Permissions -->
                    <div>
                        <h3 class="text-sm font-semibold text-gray-700 mb-3">Permissions</h3>
                        <div v-if="permissions.length" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div
                                v-for="(perms, group) in groupedPermissions"
                                :key="group"
                                class="border border-gray-200 rounded-lg p-4 bg-gray-50"
                            >
                                <!-- Group header with select-all toggle -->
                                <label class="flex items-center gap-2 mb-3 cursor-pointer">
                                    <input
                                        type="checkbox"
                                        :checked="groupAllChecked(perms)"
                                        @change="(e) => toggleAll(perms, (e.target as HTMLInputElement).checked)"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                    />
                                    <span class="text-xs font-bold uppercase tracking-wide text-gray-600 capitalize">{{ group }}</span>
                                </label>
                                <!-- Individual permissions -->
                                <div class="space-y-2 pl-1">
                                    <label
                                        v-for="perm in perms"
                                        :key="perm.id"
                                        class="flex items-center gap-2 cursor-pointer"
                                    >
                                        <input
                                            type="checkbox"
                                            :value="perm.id"
                                            v-model="roleForm.permissions"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                                        />
                                        <span class="text-sm text-gray-700">{{ perm.name.trim() }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <p v-else class="text-sm text-gray-400">No permissions found. Run the seeder first.</p>
                    </div>

                    <Button :disabled="roleForm.processing">Update Role</Button>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>
