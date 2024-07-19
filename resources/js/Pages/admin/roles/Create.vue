<template>
    <AdminLayout>
        <div id="edit-user">
            <Card>
                <template #header>
                    <h1>Create Role</h1>
                </template>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                        <Label label="Name" name="name">
                            <Input v-model="roleForm.name" />
                        </Label>
                    </div>
                    <Button>Create Role</Button>
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
        const roleForm = useForm({
            name: ''
        });

        function submit() {
            roleForm.post(route("admin.roles.store"));
        }

        return {
            roleForm,
            submit,
        };
    },
});
</script>
