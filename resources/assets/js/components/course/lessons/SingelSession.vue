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
                    <!-- <a
                        href="#"
                        class="btn btn-primary btn-sm"
                        @click.prevent="newQuestionForm = !newQuestionForm"
                    > New Question</a> -->
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
export default {
    components: {
        Resources,
        EditSession
    },
    props: {
        session: {
            type: Object,
            required: true
        }
    },
    data () {
        return {
            editSession: false
        }
    },
    methods: {
        updatesession (session) {
            this.editSession = false
        }
    }
}
</script>
