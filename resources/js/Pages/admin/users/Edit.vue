<template>
    <AdminLayout>
        <div id="edit-user">
            <Card>
                <template #header>
                    <h3>Edit User</h3>
                </template>
                <form @submit.prevent="submit">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-2">
                        <Label label="First Name" name="firstname">
                            <Input v-model="userForm.firstname" />
                        </Label>
                        <Label label="Last name" name="lastname">
                            <Input v-model="userForm.lastname" />
                        </Label>
                        <Label label="Username" name="name">
                            <Input v-model="userForm.name" />
                        </Label>
                        <Label label="Email" name="email">
                            <Input type="email" v-model="userForm.email" />
                        </Label>
                    </div>
                    <Button>Update User</Button>
                </form>
            </Card>
        </div>
    </AdminLayout>
</template>

<script lang="ts">
import { defineComponent, PropType } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Label from '@/Components/Form/Label.vue'
import Input from '@/Components/Form/Input.vue'
import { User } from '@/types'
import { router, useForm } from '@inertiajs/vue3'
import Card from '@/Components/Card.vue'
import Button from '@/Components/Button.vue'


export default defineComponent({
    components: {
        AdminLayout,
        Label,
        Input,
        Card,
        Button
    },
    props: {
        user: {
            type: Object as PropType<User>,
            required: true
        },
    },
    setup(props) {
        const userForm = useForm({
            id: props.user.id,
            firstname: props.user.firstname,
            lastname: props.user.lastname,
            name: props.user.name,
            email: props.user.email
        })

        function submit() {
            userForm.put(route('admin.users.update', props.user.id))
        }

        return {
            userForm,
            submit
        }
    }
})

</script>