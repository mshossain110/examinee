<template>
    <div class="card border-0 d-flex flex-row align-items-center justify-content-center">
        <div class="card-icon px-2 rounded-circle">
            <i class="fas fa-eye fa-2x" />
        </div>
        <div class="card-body">
            <div class="card-title d-flex align-items-center">
                <RouterLink
                    :to="{name: 'singellesson', params: { course: $route.params.course, lesson: lesson.slug}}"
                >
                    <h4>{{ lesson.title }}</h4>
                </RouterLink>
                <p class="text-secondary mt-2 ml-3">
                    <i class="far fa-clock" />
                    Duation 2:40 hour
                </p>
                <span class="badge badge-primary ml-3">{{ lesson.status }}</span>
            </div>

            <p class="card-text">
                {{ lesson.short_text }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        lesson: {
            type: Object,
            required: true
        }
    },
    data: () => ({
        courseslug: ''
    }),
    mounted () {

    }

}
</script>

<style>

</style>
