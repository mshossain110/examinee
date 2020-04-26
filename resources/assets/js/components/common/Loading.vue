<template>
    <div class="ex-loading">
        <i
            v-if="spinner"
            class="fas fa-spinner fa-7x fa-spin"
        />
        <img
            v-else
            src="/images/assets/modern-ajax-loader.gif"
            alt=""
        >
    </div>
</template>
<script>
export default {
    props: {
        spinner: Boolean
    }
}
</script>
