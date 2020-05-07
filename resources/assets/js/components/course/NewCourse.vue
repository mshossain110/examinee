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
                        <Editor v-model="course.description" />
                    </div>
                    <div class="form-group">
                        <label for="features">Features</label>
                        <Feature
                            v-model="course.features"
                        />
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
                        >Feature image</label>

                        <template v-if="thumbanile">
                            <FilesPreview
                                :files="attachments"
                                closable
                                @close="detachFile"
                            />
                        </template>
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
                        <label
                            for="course_image"
                            class="control-label"
                        >Course Files</label>
                        <AttachFiles
                            v-model="attachments"
                            multiple
                            sidebar
                        />
                        <div class="form-group">
                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Create
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script>
import AttachFiles from '@c/common/dropzone/AttachFiles.vue'
import FilesPreview from '@c/common/dropzone/FilesPreview.vue'
import Editor from '@c/common/editor/Editor.vue'
import Feature from './Feature'
export default {
    components: {
        AttachFiles,
        FilesPreview,
        Editor,
        Feature
    },
    props: {
        course: {
            type: Object,
            default () {
                return {
                    title: '',
                    subtitle: '',
                    description: '',
                    thumbnail: null,
                    features: [],
                    requirements: '',
                    start_date: '',
                    certified: 1,
                    slug: '',
                    price: 0,
                    status: 1,
                    files: []

                }
            }
        }
    },
    data () {
        return {
            slugReadonly: true,
            slugEditable: !this.course.id,
            attachments: [],
            thumbanile: null
        }
    },
    computed: {

    },
    mounted () {
        this.attachments = this.course.files.slice()
        this.thumbanile = this.course.thumbnail
    },
    methods: {
        submit () {
            var params = this.course
            delete params.files
            delete params.thumbnail

            params.files = this.attachments.map(a => a.id)
            if (this.thumbanile) {
                params.thumbnail = this.thumbanile.id
            } else {
                params.thumbnail = null
            }

            if (!this.course.id) {
                axios.post('/api/course', params)
                    .then(response => {
                        this.$emit('store', response.data.data)
                        this.$router.push({
                            name: 'coures-lessons',
                            params: {
                                id: response.data.data.id
                            }
                        })
                    })
            } else {
                axios.put(`/api/course/${this.course.id}`, params)
                    .then(response => {
                        this.$emit('update', response.data.data)
                    })
            }
        },
        titleInput (text) {
            this.course.title = text
            if (this.slugReadonly && this.slugEditable) {
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
        },
        detachThumb (file) {
            if (this.thumbanile.id === file.id) {
                this.thumbanile = null
            }
        },
        detachFile (file) {
            const i = this.attachments.findIndex(f => f.id === file.id)
            if (i !== -1) {
                this.attachments.splice(i, 1)
            }
        }
    }
}
</script>
