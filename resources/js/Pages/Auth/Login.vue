<script setup lang="ts">
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import Label from '@/Components/Form/Label.vue';
import Input from '@/Components/Form/Input.vue';
import Button from '@/Components/Button.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';
import SocialiteLogins from '@/Components/SocialiteLogins.vue'

const page = usePage();
const isDevEnv = ['local', 'development'].includes((page.props as any).appEnv as string);

defineProps<{
    canResetPassword?: boolean;
    status?: string;
}>();

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => {
            form.reset('password');
        },
    });
};

const demoUsers = [
    { label: 'Admin',   email: 'admin@admin.com',   password: 'password', color: 'bg-red-100 text-red-700 hover:bg-red-200 border-red-200' },
    { label: 'Teacher', email: 'teacher@admin.com', password: 'password', color: 'bg-blue-100 text-blue-700 hover:bg-blue-200 border-blue-200' },
    { label: 'Student', email: 'student@admin.com', password: 'password', color: 'bg-green-100 text-green-700 hover:bg-green-200 border-green-200' },
];

function loginAs(email: string, password: string) {
    form.email = email;
    form.password = password;
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <Label label="Email" :error="form.errors.email">

                <Input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                </Label>
            </div>

            <div class="mt-4">
                <Label label="Password" :error="form.errors.password">

                    <Input
                        id="password"
                        type="password"
                        class="mt-1 block w-full"
                        v-model="form.password"
                        required
                        autocomplete="current-password"
                    />
                </Label>
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
                >
                    Forgot your password?
                </Link>

                <Button class="ms-4" size="lg" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Log in
                </Button>
            </div>
        </form>
        <SocialiteLogins />

        <!-- Demo quick-login (dev / local only) -->
        <div v-if="isDevEnv" class="mt-6 border-t border-dashed border-gray-300 pt-5">
            <p class="text-xs text-center text-gray-400 mb-3 font-medium uppercase tracking-wide">Demo Login Shortcuts</p>
            <div class="flex gap-2 justify-center">
                <button
                    v-for="demo in demoUsers"
                    :key="demo.label"
                    type="button"
                    :class="['flex-1 text-xs font-semibold py-2 px-3 rounded-lg border transition-colors', demo.color]"
                    :disabled="form.processing"
                    @click="loginAs(demo.email, demo.password)"
                >
                    {{ demo.label }}
                </button>
            </div>
        </div>
    </GuestLayout>
</template>
