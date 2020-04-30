<template>
    <div class="resource">
        <Lesson
            v-if="isLesson"
            :lesson="resource"
        />
        <Exam
            v-if="isExam"
            :exam="resource"
        />
    </div>
</template>

<script>
import Lesson from './Lesson'
import Exam from './Exam'
export default {
    components: {
        Lesson,
        Exam
    },
    props: {
        resource: {
            type: Object,
            required: true
        }
    },
    computed: {
        isLesson () {
            return this.resource.pivot.sessionable_type === 'App\\Lesson'
        },
        isExam () {
            return this.resource.pivot.sessionable_type === 'App\\Exam'
        }
    }
}
</script>

<style>

</style>
