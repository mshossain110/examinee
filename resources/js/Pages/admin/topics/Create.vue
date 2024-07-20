<template>
    <AdminLayout>
        <div id="edit-topic">
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
import { defineComponent} from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import { Role } from "@/types";
import { useForm } from "@inertiajs/vue3";
import Card from "@/Components/Card.vue";
import Button from "@/Components/Button.vue";

export default defineComponent({
    components: {
        AdminLayout,
        Label,
        Input,
        Card,
        Button,
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

        return {
            form,
            submit,
        };
    },
});
</script>
