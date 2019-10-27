<template>
    <div class="new-lesson mb-5">
        <div class="card p-3">
            <div class="card-body">
                <form
                    action=""
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
                        <FileUploader
                            v-model="thumbnail"
                            :upload-multiple="false"
                            auto-process-queue
                            accepted-files="image/*"
                        />
                    </div>
                    <div class="form-group">
                        <label for="short_text">Short Text</label>
                        <input
                            id="short-text"
                            v-model="lesson.short_text"
                            type="short_text"
                            class="form-control"
                            aria-describedby="short_text"
                            placeholder="lesson short_text"
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
                                Public
                            </option>
                            <option value="2">
                                Hidden
                            </option>
                            <option value="3">
                                Subscribers
                            </option>
                            <option value="4">
                                Archived
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
                        <label for="object&quot;">Object</label>
                        <input
                            id="object&quot;"
                            v-model="lesson.object"
                            type="object&quot;"
                            class="form-control"
                            aria-describedby="object&quot;"
                            placeholder="lesson object"
                        >
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

export default {
    components: {
        Multiselect
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
                    thumbnail: '',
                    type: '1',
                    object: '',
                    status: '1',
                    course_id: ''

                }
            }
        }
    },
    data () {
        return {
            slugReadonly: true,
            thumbnail: [],
            topics: [],
            selectTopics: [],
            isLoading: false,
            topicTimeout: null
        }
    },
    methods: {
        submit () {
            var params = this.lesson
            params.course_id = this.$route.params.course
            params.topics = this.selectTopics.map(t => t.id)
            axios.post('/api/lessons', params)
                .then(response => {
                    this.$emit('new-lesson', response.data.data)
                })
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
        }

    }
}
</script>
