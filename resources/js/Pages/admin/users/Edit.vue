<template>
    <AdminLayout>
        <div id="edit-user">
            <Card class="mb-5">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-lg">Edit User</h1>
                        <Breadcrumb :items="breadcrumb" />
                    </div>
                    <div>
                        <Link :href="route('admin.users.index')" class="inline-flex items-center gap-1.5 text-sm text-gray-500 hover:text-indigo-600 dark:text-gray-400 dark:hover:text-indigo-400 transition-colors">
                            <ArrowLeftIcon class="h-4 w-4" />
                            Back to Users
                        </Link>
                    </div>
                </div>
            </Card>

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
import { defineComponent, PropType, computed } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue';
import Label from '@/Components/Form/Label.vue'
import Input from '@/Components/Form/Input.vue'
import Breadcrumb from '@/Components/Breadcrumb.vue'
import { User, LinkType } from '@/types'
import { Link, router, useForm } from '@inertiajs/vue3'
import Card from '@/Components/Card.vue'
import Button from '@/Components/Button.vue'
import { ArrowLeftIcon } from '@heroicons/vue/24/outline'


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

        const breadcrumb = computed<LinkType[]>(() => [
            { name: 'Users', href: route('admin.users.index'), current: false },
            { name: `${props.user.firstname} ${props.user.lastname}`.trim() || props.user.name, href: route('admin.users.edit', props.user.id), current: true },
        ]);

        return {
            userForm,
            submit,
            breadcrumb,
        }
    }
})

</script>