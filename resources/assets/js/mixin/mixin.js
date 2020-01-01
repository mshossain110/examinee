export default {
    data () {
        return {

        }
    },
    methods: {
        momentDate (date) {
            return moment.utc(date).format('MMM DD YYYY')
        },
        fromNow (date) {
            return moment.utc(date).fromNow()
        }
    }
}
