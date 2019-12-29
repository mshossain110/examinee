<template>
    <div class="resource-list">
        <div
            v-for="resource in resources"
            :key="resource.id"
            class="Singel-resource"
        >
            <Resource
                :resource="resource"
            />
        </div>
    </div>
</template>

<script>
import Resource from './SingelResource'
export default {
    components: {
        Resource
    },
    props: {
        resources: {
            type: Array,
            required: true
        }
    }
}
</script>
