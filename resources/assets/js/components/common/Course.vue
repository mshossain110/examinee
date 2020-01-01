<template>
    <Component
        :is="tag"
        class="course"
    >
        <div class="card mb-3">
            <slot
                name="image"
                :course="course"
            >
                <div class="card_img">
                    <i class="fas fa-play-circle" />
                    <img
                        :src="thumbnail"
                        class="card-img-top"
                        alt=""
                    >
                </div>
            </slot>

            <div class="card-body">
                <slot
                    name="title"
                    :course="course"
                >
                    <h5 class="card-title">
                        {{ course.title }}
                    </h5>
                </slot>
                <slot
                    name="description"
                    :course="course"
                >
                    <p class="card-text">
                        {{ course.description }}
                    </p>
                </slot>
                <slot
                    name="progress"
                    :course="course"
                >
                    <div
                        v-if="progress"
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
                </slot>
                <slot />
            </div>
            <div class="card-footer">
                <slot
                    name="footer"
                    :course="course"
                />
                <slot

                    name="button"
                    :course="course"
                >
                    <a
                        v-if="buttonable"
                        class="btn btn-primary btn-sm text-white"
                    >{{ button }}</a>
                </slot>
            </div>
        </div>
    </Component>
</template>
<script>
export default {
    props: {
        course: {
            type: Object,
            required: true
        },
        tag: {
            type: String,
            default: 'div'
        },
        progress: {
            type: Boolean,
            default: false
        },
        buttonable: {
            type: Boolean,
            default: false
        },
        button: {
            type: String,
            default: 'Start Learning'
        }
    },
    computed: {
        thumbnail () {
            if (this.course.thumbnail) return this.course.thumbnail.public_path

            return 'https://tricksinfo.net/wp-content/uploads/2019/07/533430_ce1e_3-750x405.jpg'
        }
    }
}
</script>
