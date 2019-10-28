import Course from './Course'

export default [
    {
        path: '/learning/my-courses',
        redirect: { name: 'my-courses' },
        component: {
            render (c) {
                return c('router-view')
            }
        },
        children: [
            {
                path: '/',
                name: 'my-courses',
                component: Course
            }
        ]
    }
]
