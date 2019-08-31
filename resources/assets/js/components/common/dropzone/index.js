
// This exports the plugin object.
export default {
    // The install method will be called with the Vue constructor as
    // the first argument, along with possible options
    install (Vue, options) {
        Vue.component('FileUploader', require('./FileUploader.vue').default)
        Vue.component('Dropzone', require('./Dropzone.vue').default)
    }
}
