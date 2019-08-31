import Course from './Course.vue'

export default [
    {
        path: '/instructor/courses',
        redirect: { name: 'course' },
        component: {
            render (c) {
                return c('router-view')
            }
        },
        children: [
            {
                path: '/',
                name: 'course',
                component: Course
            }
        ]
    }
]
