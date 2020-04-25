<template>
    <div class="video-preview">
        <video
            id="player"
            playsinline
            controls
        >
            <source
                :src="file.public_path"
                :type="file.mime"
            >

            <!-- Captions are optional -->

        </video>
    </div>
</template>

<script>
export default {
    props: {
        file: {
            type: Object,
            required: true
        },
        autoplay: {
            type: Boolean,
            default: false
        },
        options: {
            type: Object,
            default: () => ({})
        }
    },
    data: () => ({
        player: null,
        playerEvents: ['progress', 'playing', 'play', 'pause', 'timeupdate', 'volumechange', 'seeking', 'seeked', 'ratechange', 'ended', 'ready']
    }),
    mounted () {
        const defaultOptions = {
            disableContextMenu: true,
            autoplay: this.autoplay
        }

        const options = Object.assign({}, this.options, defaultOptions)
        this.player = new Plyr('#player', options)

        this.playerEvents.forEach(eventName => {
            this.player.on(eventName, (event) => this.$emit(eventName, event))
        })
    },
    destroy () {
        this.player.destroy()
    },
    methods: {
        play () {
            this.player.play()
        },
        pause () {
            this.player.pause()
        },
        togglePlay (toggle) {
            this.player.togglePlay(toggle)
        },
        stop () {
            this.player.stop()
        },
        restart () {
            this.player.restart()
        },
        rewind (time) {
            this.player.rewind(time)
        },
        forward (time) {
            this.player.forward(time)
        },
        increaseVolume (step) {
            this.player.increaseVolume(step)
        },
        decreaseVolume (step) {
            this.player.decreaseVolume(step)
        },
        toggleCaptions (toggle) {
            this.player.toggleCaptions(toggle)
        },
        fullscreenEnter () {
            this.player.fullscreen.enter()
        },
        fullscreenExit () {
            this.player.fullscreen.exit()
        },
        fullscreenToggle () {
            this.player.fullscreen.toggle()
        },
        airplay () {
            this.player.airplay()
        },
        toggleControls (toggle) {
            this.player.toggleControls(toggle)
        },
        destroy () {
            this.player.destroy()
        }
    }

}
</script>
