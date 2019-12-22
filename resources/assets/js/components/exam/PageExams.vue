<template>
    <div class="page">
        <div class="card border-0">
            <div class="card-body d-flex justify-content-between">
                <div class="w-25">
                    <div class="input-group mb-3">
                        <input
                            type="text"
                            class="form-control"
                            placeholder="Search"
                        >
                        <div class="input-group-append">
                            <span
                                id="basic-addon2"
                                class="input-group-text"
                            >Search</span>
                        </div>
                    </div>
                </div>
                <div class="w-25 text-right">
                    <button
                        type="button"
                        class="btn btn-primary"
                    >
                        Create Exam
                    </button>
                </div>
            </div>
        </div>
        <NewExam />
        <NewQuestion />
    </div>
</template>

<script>
import NewExam from './NewExam'
import NewQuestion from './NewQuestion'
export default {
    components: {
        NewExam,
        NewQuestion
    },
    data () {
        return {

        }
    },
    computed: {

    },
    created () {

    },
    methods: {

    }
}
</script>
