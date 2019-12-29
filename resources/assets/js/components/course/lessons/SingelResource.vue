
<template>
    <div class="card border-0">
        <div class="card-header d-flex justify-content-between">
            <div>
                <span
                    v-if="isLesson"
                >
                    <i class="fas fa-book-reader" />
                </span>
                <span v-if="isExam">
                    <i class="fas fa-graduation-cap" />
                </span>
                {{ resource.title }}
            </div>
            <div class="card-action">
                <div v-if="isLesson">
                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
                        @click.prevent="editLessonForm = !editLessonForm"
                    ><i class="fas fa-edit" /></a>

                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
                    ><i class="fas fa-trash-alt" /></a>
                </div>
                <div v-if="isExam">
                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
                    ><i class="fas fa-times-circle" /></a>
                </div>
            </div>
        </div>
        <div
            v-if="isLesson && editLessonForm"
            class="card-body"
        >
            <NewLesson
                :lesson="resource"
                @update="editLessonForm=false"
            />
        </div>
    </div>
</template>

<script>
import NewLesson from './NewLesson'
export default {
    components: {
        NewLesson
    },
    props: {
        resource: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            editLessonForm: false
        }
    },
    computed: {
        isLesson () {
            return this.resource.pivot.sessionable_type === `App\\Lesson`
        },
        isExam () {
            return this.resource.pivot.sessionable_type === `App\\Exam`
        }
    }
}
</script>
