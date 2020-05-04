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
                    v-if="isLesson(resource)"
                    :to="{name: 'singleLesson', params: { course: $route.params.course, lesson: resource.id}}"
                >
                    <i class="fas fa-book-reader" />
                    {{ resource.title }}
                </RouterLink>
                <RouterLink
                    v-if="isExam(resource)"
                    :to="{name: 'singleExam', params: { course: $route.params.course, exam: resource.id}}"
                >
                    <i class="fas fa-graduation-cap" />
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
    }),
    computed: {

    },
    methods: {
        isLesson (resource) {
            return resource.pivot.sessionable_type === 'App\\Lesson'
        },
        isExam (resource) {
            return resource.pivot.sessionable_type === 'App\\Exam'
        }
    }

}
</script>

<style>

</style>
