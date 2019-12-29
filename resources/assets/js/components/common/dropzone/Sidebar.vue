<template>
    <div
        class="card"
    >
        <img
            :src="file.public_path"
            class="card-img-top"
            :alt="file.name"
        >
        <div class="card-body">
            <div class="fdetails border-bottom my-3 pb-3">
                <div><strong>Name</strong>{{ file.name }}</div>
                <div><strong>Type</strong>{{ file.type }}</div>
                <div><strong>Extension</strong>{{ file.extension }}</div>
                <div><strong>File Size</strong>{{ file.file_size }}</div>
            </div>
            <form
                v-if="canEditFile"
                @submit.prevent="submit"
            >
                <div class="form-group">
                    <label for="name">Name</label>
                    <input
                        v-model="item.name"
                        type="text"
                        class="form-control"
                    >
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea
                        v-model="item.description"
                        class="form-control"
                    />
                </div>
                <div class="form-group">
                    <label for="public_path">Public Puth</label>
                    <input
                        :value="item.public_path"
                        type="text"
                        readonly
                        class="form-control"
                    >
                </div>
                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Save
                </button>
                <button
                    type="button"
                    class="btn btn-danger"
                    @click.prevent="deleteFile"
                >
                    Delete
                </button>
            </form>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        file: {
            type: Object,
            required: true
        },
        editable: {
            type: [Boolean, String],
            default: 'owner',
            validator (val) {
                return ['owner', true, false].indexOf(val) !== -1
            }
        }
    },
    data () {
        return {
            item: this.file
        }
    },
    computed: {
        canEditFile () {
            if (this.editable === 'owner') {
                return this.file.uploaded_by === Examinee.user.id
            }

            return this.editable
        }
    },
    watch: {
        file (val) {
            this.item = val
        }
    },
    created () {

    },
    methods: {
        submit () {
            const params = {
                name: this.item.name,
                description: this.item.description,
                id: this.item.id
            }

            axios.put(`/api/files/${this.file.id}`, params)
                .then(res => {
                    this.$emit('file-change', res.data.data)
                })
        },
        deleteFile () {
            const conf = confirm('File will be delete permanently!')
            if (conf) {
                axios.delete(`/api/files/${this.file.id}`)
                    .then(res => {
                        this.$emit('file-delete', res.data.data)
                    })
            }
        }
    }
}
</script>
