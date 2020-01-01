<template>
    <div
        v-if="files.length"
        class="file-preview"
    >
        <div class="file-lists">
            <div
                v-for="file in files"
                :key="file.id"
                class="items"
            >
                <template v-if="file.type == 'image'">
                    <a
                        v-fancybox
                        :href="file.public_path"
                        :title="file.name"
                    ><img
                        :src="file.public_path"
                        :alt="file.name"
                    ></a>
                </template>
                <template v-else>
                    <a
                        :href="file.public_path"
                        :title="file.name"
                        download
                    >
                        <strong>file.name</strong>
                    </a>
                </template>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    directives: {
        fancybox: {
            inserted (el) {
                var hasFaccy = jQuery.fancybox
                if (hasFaccy) {
                    jQuery(el).fancybox()
                }
            }
        }
    },
    props: {
        files: {
            type: Array,
            required: true
        }
    },
    data () {
        return {

        }
    },
    computed: {

    },
    created () {

    },
    methods: {

    }
}
</script>
