<template>
    <div class="row media-manager">
        <div class="col-12 header">
            <nav class="navbar navbar-light">
                <form
                    class="form-inline"
                    @submit.prevent="getFiles"
                >
                    <select
                        v-model="fileType"
                        class="form-control form-control-sm mr-2"
                    >
                        <option value="">
                            Filter
                        </option>
                        <option value="image">
                            Image
                        </option>
                        <option value="video">
                            Video
                        </option>
                        <option value="pdf">
                            PDF
                        </option>
                    </select>
                    <input
                        v-model="searchQuery"
                        class="form-control form-control-sm mr-2"
                        type="search"
                        placeholder="Search"
                        aria-label="Search"
                    >
                    <button
                        type="submit"
                        class="btn btn-dark btn-sm"
                    >
                        Filter
                    </button>
                </form>
                <div class="navbar-text">
                    <strong
                        v-if="!!selectedFileNumber"
                        class="mr-3"
                    > {{ selectedFileText }}</strong>
                    <a
                        v-if="!!selectedFileNumber && multipleDelete"
                        class="btn btn-outline-danger btn-sm mr-3"
                        @click.prevent="deleteFiles"
                    >
                        Delete
                    </a>
                    <a
                        class="btn btn-primary btn-sm mr-3"
                        @click.prevent="openFileUploader"
                    >
                        <i class="fas fa-cloud-upload-alt" /> Upload
                    </a>
                    <a
                        v-if="sidebar"
                        title="List View"
                        :class="{'active': sidebarInfo}"
                        @click.prevent="sidebarInfo = !sidebarInfo"
                    ><i class="fas fa-info-circle" /></a>

                    <a
                        title="List View"
                        :class="{'active': fileViewType === 'list-view'}"
                        @click.prevent="changeFileViwType('list-view')"
                    ><i class="fas fa-th-list" /></a>

                    <a
                        title="Grid View"
                        :class="{'active': fileViewType === 'grid-view'}"
                        @click.prevent="changeFileViwType('grid-view')"
                    ><i class="fas fa-th" /></a>
                </div>
            </nav>
        </div>
        <div
            class="col-12 file-container"
            @dragenter="activeDropzone"
            @dragleave="deactiveDropzone"
        >
            <div
                class="row"
            >
                <div class="col-12">
                    <FileUploader
                        ref="mediaUploader"
                        v-model="attachments"
                        :style="fileUploaderStyle"
                        auto-process-queue
                        @complete-queue="completeMultiple"
                    />
                </div>
            </div>
            <div
                v-if="!fileUploader"
                class="row"
            >
                <div :class="{ 'col-8': showSidebar, 'col-12': !showSidebar}">
                    <div
                        v-if="showLocalFiles.length"
                        class="file-items"
                        :class="fileViewType"
                        @scroll="ScrollToBottom"
                    >
                        <ul>
                            <li
                                v-for="f in showLocalFiles"
                                :key="f.id"
                                class="file"
                                :class="{'selectd': isSelected(f)}"
                                @click.prevent="selectUnselectFile(f)"
                            >
                                <input
                                    type="checkbox"
                                    :checked="isSelected(f)"
                                    @change="selectUnselectFile(f)"
                                >
                                <div class="bar">
                                    <img
                                        v-if="f.type === 'image'"
                                        :src="f.public_path"
                                        alt="f.name"
                                    >
                                    <i
                                        v-else
                                        class="fas fa-file-video fa-5x"
                                        :class="`fa-file-${f.type}`"
                                    />
                                </div>
                                <div class="name">
                                    {{ f.name }}
                                </div>
                                <div
                                    v-if="f.uploader"
                                    class="uploader"
                                >
                                    {{ f.uploader.full_name }}
                                </div>
                                <div class="ulat">
                                    {{ momentDate(f.updated_at) }}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div
                        v-else
                        class="nofile"
                    >
                        <h3>No uploaded file found!</h3>
                        <a
                            class="btn btn-primary btn-lg mr-3"
                            @click.prevent="openFileUploader"
                        >
                            <i class="fas fa-cloud-upload-alt" /> Upload
                        </a>
                    </div>
                    <div
                        v-if="isLoading"
                        style="text-align: center;padding: 20px;background: #efefef;"
                    >
                        <i class="fas fa-spinner fa-pulse fa-3x" />
                    </div>
                </div>
                <div
                    v-if="showSidebar"
                    class="col-4 sidebar"
                >
                    <Sidebar
                        :file="sidebarFile"
                        :editable="editable"
                    />
                </div>
            </div>
        </div>
        <div class="footer d-flex justify-content-between align-items-center">
            <div class="selectd">
                {{ selectedFiles.length }} files selected
            </div>
            <div class="action">
                <button
                    class="btn btn-primary"
                    @click.prevent="attachFiles"
                >
                    Attach File
                </button>
            </div>
        </div>
    </div>
</template>

<script>
import Sidebar from './Sidebar'
export default {
    components: {
        Sidebar
    },
    props: {
        course: {
            type: Number,
            default: null
        },
        multiple: {
            type: Boolean,
            default: false
        },
        sidebar: {
            type: Boolean,
            default: false
        },
        multipleDelete: {
            type: Boolean,
            default: false
        },
        editable: {
            type: [Boolean, String],
            default: 'owner',
            validator (val) {
                return ['owner', true, false].indexOf(val) !== -1
            }
        },
        value: {
            type: [Array, Object],
            default: null
        }
    },
    data () {
        return {
            attachments: [],
            fileViewType: 'grid-view',
            isLoading: false,
            fileUploader: false,
            localFiles: [],
            sidebarInfo: this.sidebar,
            localFilesMeta: {},
            selectedFiles: this.multiple ? [] : {},
            fileType: '',
            searchQuery: ''
        }
    },
    computed: {
        showLocalFiles () {
            let files = _.chain(this.localFiles).uniqBy('id')

            if (this.fileType) {
                files = files.filter(f => f.type === this.fileType)
            }
            if (this.searchQuery) {
                var re = new RegExp(this.searchQuery, 'g')
                files = files.filter(f => f.name.match(re))
            }
            return files.value()
        },
        fileUploaderStyle () {
            const style = {
                width: '100%',
                height: '250px'
            }
            if (this.fileUploader) {
                style.display = 'block'
            } else {
                style.display = 'none'
            }

            return style
        },
        showSidebar () {
            // eslint-disable-next-line no-prototype-builtins
            return this.sidebarInfo && (this.selectedFiles.hasOwnProperty('id') || this.selectedFiles.length)
        },
        sidebarFile () {
            if (this.multiple) {
                return this.selectedFiles[this.selectedFiles.length - 1]
            }

            return this.selectedFiles
        },
        selectedFileNumber () {
            if (this.multiple && this.selectedFiles.length) {
                return this.selectedFiles.length
            // eslint-disable-next-line no-prototype-builtins
            } else if (this.selectedFiles.hasOwnProperty('id')) {
                return 1
            }

            return 0
        },
        selectedFileText () {
            return this.selectedFileNumber && this.selectedFileNumber > 1 ? `${this.selectedFileNumber} Files Selected` : `${this.selectedFileNumber} File Selected`
        }

    },
    created () {
        this.getFiles()
    },
    mounted () {
        if (this.value) {
            this.selectedFiles = this.value.slice()
        }
    },
    methods: {
        changeFileViwType (type) {
            this.fileViewType = type
        },
        getFiles (page) {
            if (this.isLoading) {
                return
            }
            this.isLoading = true

            const params = {
                page: typeof page === 'number' ? page : 1,
                type: this.fileType,
                search: this.searchQuery
            }

            if (this.course) {
                params.course_id = this.course.id
            }

            axios.get('/api/files', { params: params })
                .then(res => {
                    this.localFiles = _.unionBy(this.localFiles, res.data.data)

                    this.localFilesMeta = res.data.meta
                    this.isLoading = false
                })
        },
        ScrollToBottom (event) {
            const target = event.target
            if (target.scrollTop + target.clientHeight < target.scrollHeight - 50) {
                return
            }

            if (this.localFilesMeta.current_page === this.localFilesMeta.last_page) {
                return
            }

            this.getFiles(this.localFilesMeta.current_page + 1)
        },
        activeDropzone (event) {
            event.stopPropagation()
            event.preventDefault()

            this.fileUploader = true

            return true
        },
        deactiveDropzone () {
            event.stopPropagation()
            if (this.fileUploader) {
                event.preventDefault()
                this.fileUploader = false
            }

            return true
        },
        completeMultiple () {
            if (this.localFiles.length) {
                this.localFiles = this.localFiles.concat(this.attachments)
            } else {
                this.localFiles = this.attachments
            }
            this.fileUploader = false
        },
        openFileUploader () {
            this.$refs.mediaUploader.openUploader()
        },
        selectUnselectFile (file) {
            if (this.multiple) {
                const i = this.selectedFiles.findIndex(f => f.id === file.id)
                if (i !== -1) {
                    this.selectedFiles.splice(i, 1)
                } else {
                    this.selectedFiles.push(file)
                }
            } else {
                if (this.selectedFiles.id === file.id) {
                    this.selectedFiles = {}
                } else {
                    this.selectedFiles = file
                }
            }
        },
        isSelected (file) {
            if (this.selectedFiles.length) {
                return this.selectedFiles.findIndex(f => f.id === file.id) !== -1
            }

            return this.selectedFiles.id === file.id
        },
        deleteFiles () {
            const conf = confirm('Are you Sure?')
            const params = {

            }
            params.ids = this.multiple ? this.selectedFiles.map(f => f.id) : [this.selectedFiles.id]
            if (conf) {
                axios.delete('/api/files', params)
                    .then(res => {

                    })
            }
        },
        attachFiles () {
            this.$emit('input', this.selectedFiles)
            this.$emit('close')
        }
    }
}
</script>
