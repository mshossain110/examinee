<template>
    <div
        class="card mt-2"
    >
        <div class="card-header">
            {{ question.question }}
        </div>
    </div>
</template>

<script>
export default {
    props: {
        question: {
            type: Object,
            required: true
        }
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
