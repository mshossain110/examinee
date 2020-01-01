<template>
    <div class="session-list">
        <div
            v-for="session in sessions"
            :key="session.id"
            class="singel-session mt-3"
        >
            <Session
                :session="session"
            />
        </div>
    </div>
</template>

<script>
import Session from './SingelSession'
export default {
    components: {
        Session
    },
    props: {
        sessions: {
            type: Array,
            required: true
        }
    }
}
</script>
