import Courses from './Courses'
// import SingleCourse from './Course/SingleCourse'
import SingleResource from './Lesson/SingleResource'
import SingleLesson from './Lesson/SingleLesson'
import SingleExam from './Lesson/SingleExam'

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
            // {
            //     path: ':course',
            //     name: 'singleCourse',
            //     component: SingleCourse
            // },
            {
                path: ':course',
                name: 'singleResource',
                component: SingleResource,
                children: [
                    {
                        path: 'lessons/:lesson',
                        name: 'singleLesson',
                        component: SingleLesson
                    },
                    {
                        path: 'exam/:exam',
                        name: 'singleExam',
                        component: SingleExam
                    }
                ]
            }

        ]
    }
]
