<template>
    <AdminLayout>
        <div id="edit-user">
            <Card>
                <template #header>
                    <h1>Edit Topic</h1>
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
                    <Button>Update Topic</Button>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>

<script lang="ts">
import { defineComponent, PropType } from "vue";
import AdminLayout from "@/Layouts/AdminLayout.vue";
import Label from "@/Components/Form/Label.vue";
import Input from "@/Components/Form/Input.vue";
import { Topic } from "@/types";
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
    props: {
        topic: {
            type: Object as PropType<Topic>,
            required: true,
        },
    },
    setup(props) {
        const form = useForm({
            id: props.topic.id,
            title: props.topic.title,
            description: props.topic.description,
        });

        function submit() {
            form.put(route("admin.topics.update", props.topic.id));
        }

        return {
            form,
            submit,
        };
    },
});
</script>
