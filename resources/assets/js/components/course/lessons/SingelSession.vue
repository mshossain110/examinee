<template>
    <div

        class="card"
    >
        <div class="card-header">
            <div
                class="d-flex justify-content-between"
            >
                <h3>
                    {{ session.title }}
                </h3>
                <div class="card-action">
                    <a
                        href="#"
                        class="btn btn-primary btn-sm"
                        @click.prevent="newLesson = !newLesson"
                    > New Lesson</a>
                    <a
                        href="#"
                        class="btn btn-primary btn-sm"
                        @click.prevent="attachExamForm = !attachExamForm"
                    > Attach Exam</a>
                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
                    ><i class="fas fa-info-circle" /></a>
                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
                    ><i class="fas fa-cogs" /></a>

                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
                        @click.prevent="editSession = !editSession"
                    ><i class="fas fa-edit" /></a>

                    <a
                        href="#"
                        class="btn btn-primary  btn-sm"
                    ><i class="fas fa-trash-alt" /></a>
                </div>
            </div>

            <p>{{ session.description }}</p>
        </div>
        <div
            v-if="newLesson"
            class="card-body"
        >
            <NewLesson
                :session="session.id"
                @store="newlessonfrom"
            />
        </div>
        <div
            v-if="attachExamForm"
            class="card-body"
        >
            <AttachExam
                :session="session"
                @attach="attachExam"
            />
        </div>
        <div
            v-if="editSession"
            class="card-body"
        >
            <EditSession
                :session="session"
                @update="updatesession"
            />
        </div>
        <div class="card-body">
            <Resources :resources="session.resources" />
        </div>
    </div>
</template>

<script>
import Resources from './Resources'
import EditSession from './NewSession'
import NewLesson from './NewLesson'
import AttachExam from './AttachExam'
export default {
    components: {
        Resources,
        EditSession,
        NewLesson,
        AttachExam

    },
    props: {
        session: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            editSession: false,
            newLesson: false,
            attachExamForm: false
        }
    },
    methods: {
        updatesession (session) {
            this.editSession = false
        },
        newlessonfrom (lesson) {
            this.session.resources.push(lesson)
            this.newLesson = false
        },
        attachExam (exam) {
            this.session.resources.push(exam)
            this.attachExamForm = false
        }
    }
}
</script>
