<template>
    <div class="new-course mb-5">
        <div class="card p-3">
            <div class="card-body">
                <form
                    action=""
                    @submit.prevent="submit"
                >
                    <div class="form-group">
                        <label for="title">Title*</label>
                        <input
                            id="title"
                            type="text"
                            class="form-control"
                            aria-describedby="emailHelp"
                            placeholder="Course Title"
                            :value="course.title"
                            @input="titleInput($event.target.value)"
                        >
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <span
                                    id="slugEdit"
                                    class="input-group-text"
                                    @click="slugReadonly = false"
                                ><i class="far fa-edit" /></span>
                            </div>
                            <input
                                id="slug"
                                type="text"
                                class="form-control"
                                aria-describedby="slugEdit"
                                placeholder="Course slug"
                                :readonly="slugReadonly"
                                :value="course.slug"
                                @input="slugInput($event.target.value)"
                            >
                        </div>

                        <small
                            id="emailHelp"
                            class="form-text text-muted"
                        >Try To Create SEO Frindly URL</small>
                    </div>

                    <div class="form-group">
                        <label for="subtitle">Subtitle *</label>
                        <input
                            id="subtitle"
                            v-model="course.subtitle"
                            type="subtitle"
                            class="form-control"
                            aria-describedby="subtitle"
                            placeholder="Course Subtitle"
                        >
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea
                            id="description"
                            v-model="course.description"
                            placeholder=""
                            name="description"
                            class="form-control "
                        />
                    </div>
                    <div class="form-group">
                        <label for="features">Features</label>
                        <textarea
                            id="features"
                            v-model="course.features"
                            placeholder=""
                            name="features"
                            class="form-control "
                        />
                        <small
                            id="features"
                            class="form-text text-muted"
                        >Separate by New Line</small>
                    </div>
                    <div class="form-group">
                        <label for="requirements">Pre Requirements</label>
                        <textarea
                            id="requirements"
                            v-model="course.requirements"
                            placeholder=""
                            name="requirements"
                            class="form-control "
                        />
                        <small
                            id="requirements"
                            class="form-text text-muted"
                        >Separate by New Line</small>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input
                            id="price"
                            v-model="course.price"
                            type="number"
                            class="form-control"
                            aria-describedby="priceHelp"
                            placeholder="Course Price"
                        >
                    </div>
                    <div class="form-group">
                        <label
                            for="course_image"
                            class="control-label"
                        >Course image</label>
                        <input
                            id="course_image"
                            name="course_image"
                            type="file"
                            class="form-control"
                            style="margin-top: 4px;"
                        >
                        <input
                            name="course_image_max_size"
                            type="hidden"
                            value="8"
                        >
                        <input
                            name="course_image_max_width"
                            type="hidden"
                            value="4000"
                        >
                        <input
                            name="course_image_max_height"
                            type="hidden"
                            value="4000"
                        >
                        <p class="help-block" />
                    </div>
                    <div class="form-group">
                        <label
                            for="start_date"
                            class="control-label"
                        >Start date</label>
                        <input
                            id="start_date"
                            v-model="course.start_date"
                            placeholder=""
                            name="start_date"
                            type="date"
                            class="form-control date"
                        >
                        <p class="help-block" />
                    </div>
                    <div class="form-group form-check">
                        <input
                            id="status"
                            v-model="course.certified"
                            name="status"
                            type="checkbox"
                            class="form-check-input"
                        >
                        <label
                            for="status"
                            class="control-label"
                        >Certified Course</label>
                    </div>
                    <div class="form-group form-check">
                        <input
                            id="status"
                            v-model="course.status"
                            name="status"
                            type="checkbox"
                            class="form-check-input"
                        >
                        <label
                            for="status"
                            class="control-label"
                        >Published</label>
                    </div>
                    <div class="form-group">
                        <button
                            type="submit"
                            class="btn btn-primary"
                        >
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        course: {
            type: Object,
            default () {
                return {
                    title: '',
                    subtitle: '',
                    description: '',
                    thumbnail: '',
                    features: '',
                    requirements: '',
                    start_date: '',
                    certified: 1,
                    slug: '',
                    price: 0,
                    status: 1

                }
            }
        }
    },
    data () {
        return {
            slugReadonly: true
        }
    },
    computed: {

    },
    created () {

    },
    methods: {
        submit () {
            var params = this.course
            axios.post('/api/course', params)
                .then(response => {

                })
        },
        titleInput (text) {
            this.course.title = text
            if (this.slugReadonly) {
                this.course.slug = this.slugify(this.course.title)
            }
        },
        slugInput (text) {
            if (this.slugReadonly) return
            this.course.slug = text
        },
        slugify (string) {
            const a = 'àáäâãåăæąçćčđďèéěėëêęğǵḧìíïîįłḿǹńňñòóöôœøṕŕřßşśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;'
            const b = 'aaaaaaaaacccddeeeeeeegghiiiiilmnnnnooooooprrsssssttuuuuuuuuuwxyyzzz------'
            const p = new RegExp(a.split('').join('|'), 'g')

            return string.toString().toLowerCase()
                .replace(/\s+/g, '-') // Replace spaces with -
                .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
                .replace(/&/g, '-and-') // Replace & with 'and'
                .replace(/[^\w-]+/g, '') // Remove all non-word characters
                .replace(/--+/g, '-') // Replace multiple - with single -
                .replace(/^-+/, '') // Trim - from start of text
                .replace(/-+$/, '') // Trim - from end of text
        }
    }
}
</script>
