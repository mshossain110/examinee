<template>
    <RouterLink :to="{name:'singelcourse',params:{course:course.slug}}">
        <div class="card mb-3">
            <div class="card_img">
                <i class="fas fa-play-circle" />
                <img
                    src="https://tricksinfo.net/wp-content/uploads/2019/07/533430_ce1e_3-750x405.jpg"
                    class="card-img-top"
                    alt=""
                >
            </div>

            <div class="card-body">
                <h5 class="card-title">
                    {{ course.title }}
                </h5>
                <p class="card-text">
                    {{ course.description }}
                </p>
                <div
                    class="progress my-2"
                    style="height: 3px;"
                >
                    <div
                        class="progress-bar"
                        role="progressbar"
                        style="width: 45%;"
                        aria-valuenow="45"
                        aria-valuemin="0"
                        aria-valuemax="100"
                    />
                </div>
                <a
                    href="#"
                    class="btn btn-primary btn-sm text-white"
                >Start Learning</a>
            </div>
        </div>
    </RouterLink>
</template>
<script>
export default {
    props: {
        course: {
            type: Object,
            required: true
        }
    },
    data () {
        return {

        }
    },
    created () {

    }
}
</script>
