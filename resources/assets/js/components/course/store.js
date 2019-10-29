export default
{
    namespaced: true,
    state: {
        course: {}
    },
    mutations: {
        setCourse (state, payload) {
            state.course = payload
        }
    }
}
