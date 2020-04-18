<template>
    <div

        class="card"
    >
        <div class="card-header">
            <h5>
                {{ session.title }}
            </h5>
            <div
                class="description"
                style="font-size:13px;"
            >
                <p class="m-0">
                    {{ session.description }}
                </p>
            </div>
            <div class="s-action">
                <a
                    href="#"
                    class="ex-btn"
                    @click.prevent="newLesson = !newLesson"
                > New Lesson</a>
                <a
                    href="#"
                    class="ex-btn"
                    @click.prevent="attachExamForm = !attachExamForm"
                > Attach Exam</a>
                <a
                    href="#"
                    class="ex-icon"
                    @click.prevent="editSession = !editSession"
                ><i class="fas fa-edit" /></a>

                <a
                    href="#"
                    class="ex-icon text-danger"
                    @click.prevent="deletesession"
                ><i class="fas fa-trash-alt" /></a>
            </div>
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
        <div
            v-if="session.resources.length"
            class="card-body p-0"
        >
            <Resources
                :resources="session.resources"
                @deleteLesson="deleteLesson"
            />
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
            lesson.pivot = lesson.sessionable
            this.session.resources.push(lesson)
            this.newLesson = false
        },
        attachExam (exam) {
            this.session.resources.push(exam)
            this.attachExamForm = false
        },
        deleteLesson (lesson) {
            var i = this.session.resources.findIndex(r => r.id === lesson.id && r.pivot.sessionable_type === lesson.pivot.sessionable_type)
            if (i !== -1) {
                this.session.resources.splice(i, 1)
            }
        },
        deletSession () {
            const con = confirm('Do You Want To Delete Session?')

            if (!con) {
                return
            }
            axios.delete(`/api/session/${this.session.id}`)
                .then(res => {})
        }
    }
}
</script>
