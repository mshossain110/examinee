<template>
    <div class="resource-list">
        <div
            v-for="resource in resources"
            :key="resource.id"
            class="singel-resource"
        >
            <Resource
                :resource="resource"
                @deleteLesson="$emit('deleteLesson', $event)"
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
