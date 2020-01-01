
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
            <div class="r-action">
                <div v-if="isLesson">
                    <a
                        href="#"
                        @click.prevent="editLessonForm = !editLessonForm"
                    ><i class="fas fa-edit" /></a>

                    <a
                        href="#"
                        class="text-danger"
                        @click.prevent="deleteLesson"
                    ><i class="fas fa-trash-alt" /></a>
                </div>
                <div v-if="isExam">
                    <a
                        href="#"
                        @click.prevent="deTuchLesson"
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
    },
    methods: {
        deleteLesson () {
            const con = confirm('Do You Want To Delete Lesson?')

            if (!con) {
                return
            }
            axios.delete(`/api/lessons/${this.resource.id}`)
                .then(res => {
                    this.$emit('deleteLesson', this.resource)
                })
        },
        deTuchLesson () {
            const con = confirm('Do You Want To DeTuch Lesson?')

            if (!con) {
                return
            }
            axios.delete(`/api/lessons/${this.resource.id}`)
                .then(res => {

                })
        }

    }
}
</script>
