<template>
    <div class="af">
        <a
            class="btn btn-sm btn-info"
            @click.prevent="openModal"
        >
            Attach Files
        </a>

        <Modal
            ref="afModal"
            dialog="modal-xl"
            @modal-open="modal = true"
            @modal-cosed="modal = false"
        >
            <template v-slot:header>
                <h5>Media Library</h5>
                <button
                    type="button"
                    class="close"
                    data-dismiss="modal"
                    aria-label="Close"
                    @click.prevent="cancel"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </template>
            <MediaManager
                v-if="modal"
                v-bind="$attrs"
                @input="$emit('input', $event)"
                @close="cancel"
            />
        </Modal>
    </div>
</template>

<script>
import Modal from '@c/common/Modal.vue'
import MediaManager from './MediaManager'
export default {
    components: {
        Modal,
        MediaManager
    },
    inheritAttrs: false,
    data () {
        return {
            modal: false
        }
    },
    methods: {
        openModal () {
            this.$refs.afModal.show()
        },
        cancel () {
            this.$refs.afModal.hide()
        }
    }
}
</script>
