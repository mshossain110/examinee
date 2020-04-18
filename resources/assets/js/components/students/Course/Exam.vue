<template>
    <div class="card border-0 d-flex flex-row align-items-center justify-content-center">
        <div class="card-icon px-2 rounded-circle">
            <i class="fas fa-eye fa-2x" />
        </div>
        <div class="card-body">
            <div class="card-title d-flex align-items-center">
                <RouterLink
                    :to="{name: 'singellesson', params: { course: $route.params.course, exam: exam.slug}}"
                >
                    <h4>{{ exam.title }}</h4>
                </RouterLink>
            </div>

            <p class="card-text">
                {{ exam.description }}
            </p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        exam: {
            type: Object,
            required: true
        }
    },
    data: () => ({
    }),
    mounted () {

    }

}
</script>

<style>

</style>
