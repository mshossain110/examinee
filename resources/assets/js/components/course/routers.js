import Courses from './Courses.vue'
import PageExams from './../exam/PageExams.vue'
import PageStudent from './PageMyStudent.vue'
import Discussions from './PageDiscussion.vue'
import CourseSingle from './CourseSingle.vue'
import CourseDetails from './CourseDetails.vue'
import CourseLessons from './lessons/Lessons.vue'
export default [
    {
        path: '/instructor/courses',
        redirect: { name: 'courses' },
        component: {
            render (c) {
                return c('router-view')
            }
        },
        children: [
            {
                path: '/',
                name: 'courses',
                component: Courses
            },

            {
                path: 'exams',
                name: 'exams',
                component: PageExams
            },
            {
                path: 'my-students',
                name: 'my-students',
                component: PageStudent
            },
            {
                path: 'discussion',
                name: 'discussion',
                component: Discussions
            },
            {
                path: ':id',
                name: 'course-single',
                redirect: { name: 'coures-details' },
                component: CourseSingle,
                children: [
                    {
                        path: '/',
                        name: 'coures-details',
                        component: CourseDetails
                    },
                    {
                        path: 'lessons',
                        name: 'coures-lessons',
                        component: CourseLessons
                    },
                    {
                        path: 'exams',
                        name: 'course-exams',
                        component: PageExams
                    },
                    {
                        path: 'students',
                        name: 'coures-students',
                        component: PageStudent
                    }
                ]
            }
        ]
    }
]
