import Course from './Course.vue'
import PageExams from './PageExams.vue'
import PageStudent from './PageMyStudent.vue'
import Discussions from './PageDiscussion.vue'
import CourseSingle from './CourseSingle.vue'
import CourseDetails from './CourseDetails.vue'
import CourseLessons from './lessons/Lessons.vue'
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
                component: CourseSingle,
                children: [
                    {
                        path: 'details',
                        name: 'coures-details',
                        component: CourseDetails,
                        props: true
                    },
                    {
                        path: 'lessons',
                        name: 'coures-lessons',
                        component: CourseLessons,
                        props: true
                    },
                    {
                        path: 'exams',
                        name: 'course-exams',
                        component: PageExams,
                        props: true
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
