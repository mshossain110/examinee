
<template>
    <div

        class="card"
    >
        <div class="card-header">
            <h3>
                {{ resource.title }}
            </h3>
            <p>{{ resource.description }}</p>
        </div>
        <div class="card-body">
            fgfdg
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
