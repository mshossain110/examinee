import Courses from './Courses'
import SingelCourse from './Course/SingelCourse'
import SingelLesson from './Lesson/SingelLesson'

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
                path: ':course/lessons/:lesson?',
                name: 'singellesson',
                component: SingelLesson
            }

        ]
    }
]
