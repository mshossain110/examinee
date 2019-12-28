
<template>
    <div

        class="card"
    >
        <div class="card-header">
            {{ resource.title }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        resource: {
            type: Object,
            required: true
        }
    }
}
</script>
