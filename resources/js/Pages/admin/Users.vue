<template>
  <AdminLayout>
    <div id="users" class="bg-white p-3 dark:bg-slate-800 dark:text-gray-200">
      <Breadcrumb :items="breadcrumb" />

      <div>
        <DataTable v-model="selected" :rows="response.data" :columns="columns">
            <template #name-data="{ row }">
                <div class="flex">
                    <div class="avatar">
                      <img
                          class="relative inline-block h-12 w-12 rounded-2xl object-cover object-center mr-4"
                          alt="Image placeholder"
                          :src="row.avatar.avatar"
                      />
                    </div>
                    <div class="">
                        <div> {{ row.full_name }} </div>
                        <div> {{ row.email }} </div>
                    </div>
                </div>
            </template>

            <template #actions-data="{ row }">
                <div class="flex">
                  <Link
                    @click="deleteUser(row)"
                    as="button"
                    href=""
                >
                  <TrashIcon
                    class="mr-2 h-6 w-6"
                  ></TrashIcon>
                </Link>

                </div>
            </template>

        </DataTable>
      </div>

      
      {{ selected }}

    </div>
  </AdminLayout>
</template>

<script lang="ts">
import { ChevronRightIcon, UserPlusIcon, TrashIcon  } from '@heroicons/vue/24/outline';

import CircleSvg from '@/Components/CircleSvg.vue';
import { LinkType, JsonResponse, User } from "@/types";
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { PropType } from "vue";
import { Link } from "@inertiajs/vue3";
import Breadcrumb from "@/Components/Breadcrumb.vue";
import DataTable from "@/Components/Datatable/Table.vue";
import Checkbox from '@/Components/Form/Checkbox.vue';
import Modal from '@/Components/Modal.vue';
import Card from '@/Components/Card.vue';
import { router } from '@inertiajs/vue3'


export default {
  name: 'Users',
  components: {
    AdminLayout,
    Breadcrumb,
    ChevronRightIcon,
    UserPlusIcon,
    CircleSvg,
    Link,
    DataTable,
    Checkbox,
    TrashIcon,
    Modal,
    Card

  },
  props: {
    response: {
      type: Object as PropType<JsonResponse<User[]>>,
      required: true
    },
  },
  setup() {
    const columns = [
      {
        key: 'name',
        label: 'Name',
      },
      {
        key: 'roles.0.name',
        label: 'Role',
      },
      {
        key: 'email_verified_at',
        label: 'Verified',
      },
      {
        key: 'actions',
      },
    ];
    return {
      columns
    };
  },
  data() {
    return {
      confirmingUserDeletion: false,
      selected: [],
      pagination: {},
      perPage: 10,
      dataReady: false,
      showCreateUserForm: false,
      userEditing: null,
      creatingNewUser: false,
      userFormKey: 432489,
      availableRoles: [],
      rolesDataReady: false,
      lockJigled: false,
    };
  },
  computed: {
    breadcrumb(): LinkType[] {
      return [
        { name: "Users", href: route('admin.users.index'), current: route().current("admin.users.index") },
      ]
    }
  },
  watch: {},
  created() { },
  mounted() {
  },
  beforeUnmount() { },
  updated() { },
  methods: {
    deleteUser (user: User) {
        if (confirm('Are you sure you want to delete this item?')) {
          router.delete(route('admin.users.destroy', user.id))
        }
    },
  },
};
</script>

<style scoped>
input:focus,
select:focus,
textarea:focus,
button:focus,
option:focus {
  outline: none !important;
  border: none !important;
}
</style>
