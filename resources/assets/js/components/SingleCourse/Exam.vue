<template>
    <div class="lesson-exam card border-0 d-flex flex-row align-items-center justify-content-center">
        <div class="icon">
            <i class="fas fa-graduation-cap" />
        </div>
        <div class="card-body">
            <div class="card-title d-flex align-items-center m-0">
                <RouterLink
                    :to="{name: 'singellesson', params: { course: $route.params.course, exam: exam.id}}"
                >
                    <h5>{{ exam.title }}</h5>
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
