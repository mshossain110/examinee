<template>
    <AdminLayout>
        <div id="edit-topic">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg">Create Topic</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Link :href="route('admin.topics.index')" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                            <ArrowLeftIcon class="h-4 w-4" />
                            Back to Topics
                        </Link>
                    </div>
                </div>
            </Card>

            <Card>
                <template #header>
                    <h1 class="text-lg">Create Topic</h1>
                </template>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                        <Label label="Title" name="title">
                            <Input v-model="form.title" />
                        </Label>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                        <Label label="Description" name="description">
                            <textarea v-model="form.description" name="description" cols="80" rows="8" class="relative block w-full disabled:cursor-not-allowed disabled:opacity-75 focus:outline-none border-0 form-input rounded-md placeholder-gray-400 dark:placeholder-gray-500 text-md px-3 py-2 shadow-sm bg-transparent text-gray-900 dark:text-white ring-1 ring-inset ring-blue-500 dark:ring-blue-400 focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400"></textarea>
                        </Label>
                    </div>
                    <Button>Create Topic</Button>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>

<script lang="ts">
import { defineComponent, computed } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import { LinkType } from "@/types";
import { Link, useForm } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";
import { ArrowLeftIcon } from "@heroicons/vue/24/outline";

export default defineComponent({
    components: {
        AdminLayout,
        Label,
        Input,
        Card,
        Button,
        Breadcrumb,
        Link,
        ArrowLeftIcon,
    },
    props: {},
    setup(props) {
        const form = useForm({
            title: '',
            description: ''
        });

        function submit() {
            form.post(route("admin.topics.store"));
        }

        const breadcrumb = computed<LinkType[]>(() => [
            { name: 'Topics', href: route('admin.topics.index'), current: false },
            { name: 'Create', href: route('admin.topics.create'), current: true },
        ]);

        return {
            form,
            submit,
            breadcrumb,
        };
    },
});
</script>
