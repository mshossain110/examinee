<template>
    <div class="fileUpload">
        <Dropzone
            id="fileUpload"
            ref="myVueDropzone"
            :options="dropzoneOptions"
            v-bind="$attrs"
            @vdropzone-file-added="fileAdded"
            @vdropzone-files-added="filesAdded"
            @vdropzone-success="success"
            @vdropzone-chunks-uploaded="chunksUploaded"
            @vdropzone-sending="sending"
            @vdropzone-drop="deactive"
            @vdropzone-drag-leave="deactive"
            @vdropzone-removed-file="removed"
        />
    </div>
</template>

<script>
import Dropzone from './Dropzone'
import { Promise } from 'q'

export default {
    components: {
        Dropzone
    },
    props: {
        value: {
            type: Array,
            default () {
                return []
            }
        },
        autoProcessQueue: {
            type: Boolean,
            default: false
        },
        sizes: {
            type: Array,
            default () {
                return []
            }
        }
    },
    data () {
        return {
            filesAddedpoppu: false,
            fileList: [],
            fileResponse: []
        }
    },
    computed: {
        dropzoneOptions () {
            return {
                url: '/api/file',
                method: 'POST',
                thumbnailWidth: 200,
                parallelUploads: 1,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name="csrf-token"]').content
                },
                chunking: true,
                forceChunking: true,
                maxFilesize: 400000000,
                chunkSize: 1000000,
                // If true, the individual chunks of a file are being uploaded simultaneously.
                parallelChunkUploads: true,
                retryChunks: true, // retry chunks on failure
                retryChunksLimit: 3,
                addRemoveLinks: true,
                autoProcessQueue: this.autoProcessQueue
            }
        }

    },
    mounted () {
        EventBus.$on('openDropZone', () => {
            this.openUploader()
        })
    },
    methods: {
        processQueue () {
            return new Promise((resolve, reject) => {
                this.$refs.myVueDropzone.processQueue()
                this.$refs.myVueDropzone.$on('vdropzone-queue-complete', () => {
                    resolve(this.fileResponse)
                })
                this.$refs.myVueDropzone.$on('vdropzone-error', (file, message, xhr) => {
                    reject(xhr.response)
                })
            })
        },
        openUploader () {
            this.$refs.myVueDropzone.$el.click()
        },
        deactive (event) {
            event.stopPropagation()
            event.preventDefault()
            this.$emit('input', this.fileList)
        },
        fileAdded (file) {
            this.$emit('file-added', file)
        },
        filesAdded (files) {
            this.filesAddedpoppu = true
            // loop through files
            for (var i = 0; i < files.length; i++) {
                files[i].ldporgress = 0
                this.fileList.push(files[i])
            }
            if (!this.autoProcessQueue) {
                this.$emit('input', this.fileList)
            }
        },
        success (file) {
            let response = JSON.parse(file.xhr.response)
            this.fileResponse.push(response.data)
            this.$emit('input', this.fileResponse)
        },
        chunksUploaded (file, done) {
            done()
        },

        sending (file, xhr, formData) {
            let path = file.fullPath || file.webkitRelativePath || file.mozRelativePath
            if (typeof path === 'undefined') {
                path = file.name
            }
            formData.append('path', '/' + path)
            formData.append('parent_id', 0)
            formData.append('sizes', this.sizes)
        },
        removed (file) {
            let i = this.fileList.findIndex(f => f.upload.uuid === file.upload.uuid)
            this.fileList.splice(i, 1)
            this.$emit('input', this.fileList)
        },
        removeAllFiles () {
            this.fileList = []
            this.fileResponse = []
            this.$refs.myVueDropzone.dropzone.removeAllFiles()
        }
    }
}
</script>
