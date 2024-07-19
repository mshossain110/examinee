<template>
    <AdminLayout>
        <div v-html="info" />
    </AdminLayout>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import AdminLayout from '@/Layouts/AdminLayout.vue'

export default defineComponent({
    components: {
        AdminLayout
    },
    props: {
        info: {
            type: String,
        },
    },
    setup() {
    

    }
})

</script>