<template>
    <div

        class="card"
    >
        <div class="card-header">
            <h3>
                {{ session.title }}
            </h3>
            <p>{{ session.description }}</p>
        </div>
        <div class="card-body">
            <div
                v-for="r in session.resources"
                :key="r.id"
                class="card mt-2"
            >
                <div class="card-header">
                    {{ r.title }}
                </div>
                <div class="card-body">
                    fggfdg
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        session: {
            type: Object,
            required: true
        }
    }
}
</script>
