<template>
    <div id="" class="flex flex-wrap justify-around">
        dslk;fjdlk;j
        <Link :href="route('oauth', {driver: 'facebook'})">
            Facebook
        </Link>
    </div>
</template>

<script lang="ts">
import { defineComponent } from 'vue'
import { Link } from "@inertiajs/vue3";
import Icon from '@/Components/Icon.vue'

export default defineComponent({
    components: {
        Link,
        Icon
    },
    setup() {
    

    }
})

</script>