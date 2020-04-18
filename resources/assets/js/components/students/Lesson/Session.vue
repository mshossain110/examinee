<template>
    <div class="card">
        <a
            class="card-header"
            href=""
            @click.prevent="collapse = !collapse"
        >
            <h5 class="mb-0">
                {{ session.title }}
            </h5>
        </a>

        <ul
            v-show="collapse"
            class="list-group list-group-flush"
        >
            <li
                v-for="(resource, i) in session.resources"
                :key="i"
                class="list-group-item list-group-item-action"
            >
                <RouterLink
                    :to="{name: 'singellesson', params: { course: $route.params.course, lesson: resource.id}}"
                >
                    {{ resource.title }}
                </RouterLink>
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        session: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        collapse: true
    })

}
</script>

<style>

</style>
