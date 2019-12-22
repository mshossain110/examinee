import Courses from './Courses'
import SingelCourse from './SingelCourse'
import SingelLesson from './SingelLesson'

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
                component: Courses
            },
            {
                path: ':course',
                name: 'singelcourse',
                component: SingelCourse
            },
            {
                path: ':course/:lesson',
                name: 'singellesson',
                component: SingelLesson
            }

        ]
    }
]
