<template>
    <Component
        :is="tagName"
        id="modal"
        class="modal fade"
        tabindex="-1"
        role="dialog"
        aria-labelledby="modalLabel"
        aria-hidden="true"
        :class="modalClass"
    >
        <div
            class="modal-dialog"
            :class="dialogClass"
            role="document"
        >
            <div class="modal-content">
                <div
                    v-if="hasHeaderSlot"
                    class="modal-header"
                >
                    <slot name="header" />
                </div>
                <div class="modal-body">
                    <slot />
                </div>
                <div
                    v-if="hasFooterSlot"
                    class="modal-footer"
                >
                    <slot name="footer" />
                </div>
            </div>
        </div>
    </Component>
</template>

<script>
export default {
    props: {
        backdrop: {
            type: Boolean,
            default: false
        },
        modal: {
            type: [String, Object],
            default: ''
        },
        dialog: {
            type: [String, Object],
            default: ''
        },
        tagName: {
            type: String,
            default: 'div'
        },
        scrollable: {
            type: Boolean,
            default: false
        },
        centered: {
            type: Boolean,
            default: false
        }
    },
    data () {
        return {
            isOpened: false,
            isOpening: false,
            isClosing: false
        }
    },
    computed: {
        isClosed () {
            return this.isOpened === false
        },
        hasHeaderSlot () {
            return this.$slots.header
        },
        hasFooterSlot () {
            return this.$slots.footer
        },
        modalClass () {
            const mclass = []
            if (typeof this.modal === 'string') {
                mclass.push(this.modal)
            }

            return mclass
        },
        modalStyle () {
            let mstyle = {}
            if (typeof this.modal === 'object') {
                mstyle = { ...mstyle, ...this.modal }
            }
            return mstyle
        },
        dialogClass () {
            const mclass = []
            if (typeof this.dialog === 'string') {
                mclass.push(this.dialog)
            }

            if (this.scrollable) {
                mclass.puhs('modal-dialog-scrollable')
            }

            if (this.centered) {
                mclass.push('modal-dialog-centered')
            }

            return mclass
        },
        dialogStyle () {
            let mstyle = {}
            if (typeof this.dialog === 'object') {
                mstyle = { ...mstyle, ...this.dialog }
            }
            return mstyle
        }
    },
    mounted () {
        if (this.backdrop) {
            document.addEventListener('click', this.fireBackdrop)
        } else {
            this.$el.setAttribute('data-backdrop', 'static')
        }

        jQuery(this.$el).on('shown.bs.modal', this.show)
        jQuery(this.$el).on('hidden.bs.modal', this.hide)
    },
    methods: {
        show () {
            if (this.isOpened || this.isOpening || this.isClosing) {
                return
            }
            this.isOpening = true

            this.$emit('modal-opening')
            jQuery(this.$el).modal('show')
            this.$nextTick(() => {
                this.isOpening = false
                this.isOpened = true
                this.$emit('modal-open')
            })
        },
        hide () {
            if (!this.isOpened || this.isOpening || this.isClosing) {
                return
            }
            this.isClosing = true

            this.$emit('modal-closing')

            jQuery(this.$el).modal('hide')
            this.$nextTick(() => {
                this.isClosing = false
                this.isOpened = false
                this.$emit('modal-cosed')
            })
        },
        toggle () {
            if (this.isOpened) {
                this.hide()
            } else {
                this.show()
            }
        },
        fireBackdrop (e) {
            const target = jQuery(e.target)
            if (!target.hasClass('modal-backdrop')) {
                return
            }
            this.hide()
            this.$emit('backdroped')
        }
    }
}
</script>
