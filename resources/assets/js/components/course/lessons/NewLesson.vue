<template>
    <div class="new-lesson mb-5">
        <div class="card p-3">
            <div class="card-body">
                <form
                    @submit.prevent="submit"
                >
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input
                            id="title"
                            type="text"
                            class="form-control"
                            aria-describedby="emailHelp"
                            placeholder="lesson title"
                            :value="lesson.title"
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
                                placeholder="lesson slug"
                                :readonly="slugReadonly"
                                :value="lesson.slug"
                                @input="slugInput($event.target.value)"
                            >
                        </div>

                        <small
                            id="emailHelp"
                            class="form-text text-muted"
                        >Try To Create SEO Frindly URL</small>
                    </div>
                    <div class="form-group">
                        <label
                            for="lesson_image"
                            class="control-label"
                        >Feature image</label>
                        <AttachFiles
                            v-model="thumbanile"
                            sidebar
                        />
                        <template v-if="thumbanile">
                            <FilesPreview
                                :files="[thumbanile]"
                                closable
                                @close="detachThumb"
                            />
                        </template>
                    </div>
                    <div class="form-group">
                        <label for="short-text">Short Text</label>
                        <input
                            id="short-text"
                            v-model="lesson.short_text"
                            type="short_text"
                            class="form-control"
                            aria-describedby="short_text"
                            placeholder="lesson short text"
                        >
                    </div>
                    <div class="form-group">
                        <label for="full_text">Full Text</label>
                        <textarea
                            id="full_text"
                            v-model="lesson.full_text"
                            placeholder=""
                            name="full_text"
                            class="form-control "
                        />
                    </div>
                    <div class="form-group">
                        <Multiselect
                            id="ajax"
                            v-model="selectTopics"
                            label="title"
                            track-by="id"
                            placeholder="Type to search Topic"
                            open-direction="bottom"
                            :options="topics"
                            :multiple="true"
                            :searchable="true"
                            :loading="isLoading"
                            :internal-search="false"
                            :clear-on-select="true"
                            :close-on-select="false"
                            :max-height="600"
                            :show-no-results="true"
                            :taggable="true"
                            :hide-selected="true"
                            @tag="createTopic"
                            @search-change="loadTopics"
                        >
                            <template
                                slot="tag"
                                slot-scope="{ option, remove }"
                            >
                                <span class="custom__tag"><span>{{ option.title }}</span><span
                                    class="custom__remove"
                                    @click="remove(option)"
                                >x</span></span>
                            </template>

                            <template
                                slot="clear"
                                slot-scope="props"
                            >
                                <div
                                    v-if="selectTopics.length"
                                    class="multiselect__clear"
                                    @mousedown.prevent.stop="clearAll(props.search)"
                                />
                            </template>

                            <span slot="noResult">Oops! No elements found. Consider changing the search query.</span>
                        </Multiselect>
                    </div>
                    <div class="form-group">
                        <label for="lessonStatus">Lesson Status</label>
                        <select
                            v-model="lesson.status"
                            class="custom-select custom-select-sm"
                        >
                            <option value="1">
                                Free
                            </option>
                            <option value="2">
                                Subscriber
                            </option>
                            <option value="3">
                                Paid
                            </option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="lessontType">Lesson Type</label>
                        <select
                            v-model="lesson.type"
                            class="custom-select custom-select-sm"
                        >
                            <option value="1">
                                Text
                            </option>
                            <option value="2">
                                Vedio
                            </option>
                            <option value="3">
                                Audio
                            </option>
                            <option value="4">
                                PDF
                            </option>
                        </select>
                    </div>

                    <div
                        v-if="lesson.type !== '1'"
                        class="form-group"
                    >
                        <label for="object&quot;">Object File</label>
                        <AttachFiles
                            v-model="objectFile"
                            sidebar
                        />
                        <template v-if="objectFile">
                            <FilesPreview
                                :files="[objectFile]"
                                closable
                                @close="detachObject"
                            />
                        </template>
                    </div>
                    <button
                        type="submit"
                        class="btn btn-success"
                    >
                        Create Lesson
                    </button>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
import Multiselect from 'vue-multiselect'
import AttachFiles from '@c/common/dropzone/AttachFiles.vue'
import FilesPreview from '@c/common/dropzone/FilesPreview.vue'
export default {
    components: {
        Multiselect,
        AttachFiles,
        FilesPreview
    },
    props: {
        lesson: {
            type: Object,
            default () {
                return {
                    title: '',
                    slug: '',
                    short_text: '',
                    full_text: '',
                    thumbnail: null,
                    type: '1',
                    object: null,
                    status: '1',
                    course_id: ''

                }
            }
        },
        // eslint-disable-next-line vue/require-default-prop
        session: {
            type: Number

        }
    },
    data () {
        return {
            slugReadonly: true,
            thumbnail: [],
            topics: [],
            selectTopics: [],
            isLoading: false,
            topicTimeout: null,
            thumbanile: null,
            objectFile: null
        }
    },
    mounted () {
        this.thumbanile = this.lesson.thumbnail
        this.objectFile = this.lesson.object
    },
    methods: {
        submit () {
            var params = this.lesson

            if (this.thumbanile) {
                params.thumbnail = this.thumbanile.id
            } else {
                params.thumbnail = null
            }

            if (this.objectFile) {
                params.object = this.objectFile.id
            } else {
                params.object = null
            }

            params.course_id = this.$route.params.id
            params.session = this.session
            params.topics = this.selectTopics.map(t => t.id)

            if (!this.lesson.id) {
                axios.post(`/api/lessons`, params)
                    .then(response => {
                        this.$emit('store', response.data.data)
                    })
            } else {
                axios.put(`/api/lessons/${this.lesson.id}`, params)
                    .then(response => {
                        this.$emit('update', response.data.data)
                    })
            }
        },
        titleInput (text) {
            this.lesson.title = text
            if (this.slugReadonly) {
                this.lesson.slug = this.slugify(this.lesson.title)
            }
        },
        slugInput (text) {
            if (this.slugReadonly) return
            this.lesson.slug = text
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
        loadTopics (search) {
            const params = {
                s: search
            }

            if (this.topicTimeout) {
                clearInterval(this.topicTimeout)
            }

            this.isLoading = true

            this.topicTimeout = setTimeout(() => {
                axios.get(`/api/topics`, { params })
                    .then(res => {
                        this.topics = res.data.data
                        this.isLoading = false
                    })
            }, 300)
        },
        clearAll () {
            this.selectTopics = []
        },
        createTopic (searchQuery, id) {
            const params = {
                title: searchQuery
            }

            axios.post(`/api/topics`, params)
                .then(res => {
                    this.selectTopics.push(res.data.data)
                })
        },
        detachThumb (file) {
            if (this.thumbanile.id === file.id) {
                this.thumbanile = null
            }
        },
        detachObject (file) {
            if (this.objectFile.id === file.id) {
                this.objectFile = null
            }
        }

    }
}
</script>
