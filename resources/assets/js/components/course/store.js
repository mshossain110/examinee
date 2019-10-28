export default
{
    namespaced: true,
    state: {
        course: {}
    },
    mutations: {
        setCourse (state, payload) {
            console.log('fkj')
            state.course = payload
        }
    }
}
