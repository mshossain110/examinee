<script setup lang="ts">
import { Head, Link, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { computed } from "vue";
import { Course } from "@/types";
import { ref } from "vue";
import Instractor from "./Partials/Instractor.vue";
import Pricing from "./Partials/Pricing.vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const props = defineProps<{
    course: Course;
}>();

const stats = [
    { name: "Number of student", value: props.course.students_count },
    { name: "Number of sessions", value: props.course.exam_sessions_count },
    { name: "Number of exams", value: props.course.exams_count },
    { name: "Number of lessons", value: props.course.lessons_count },
];

let loading = ref(false);
function startLearning(): void {
    if (!user) {
        return;
    }
    if (loading) {
        return;
    }

    loading = ref(true);

    window.axios
        .post(route(`course.subscribe`, { course: props.course.id }))
        .then((res) => {
            window.location.replace("/learning/my-courses");
        })
        .catch((error) => {
            if (error.response.status === 401) {
                window.location.replace("/login");
            }
        })
        .finally(() => {
            loading = ref(false);
        });
}
</script>
<template>
    <MainLayout>
        <Head title="Course" />
        <div
            class="relative isolate overflow-hidden bg-gray-900 py-24 sm:py-32"
        >
            <img
                src="https://images.unsplash.com/photo-1521737604893-d14cc237f11d?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&crop=focalpoint&fp-y=.8&w=2830&h=1500&q=80&blend=111827&sat=-100&exp=15&blend-mode=multiply"
                alt=""
                class="absolute inset-0 -z-10 h-full w-full object-cover object-right md:object-center"
            />
            <div
                class="hidden sm:absolute sm:-top-10 sm:right-1/2 sm:-z-10 sm:mr-10 sm:block sm:transform-gpu sm:blur-3xl"
                aria-hidden="true"
            >
                <div
                    class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
                    style="
                        clip-path: polygon(
                            74.1% 44.1%,
                            100% 61.6%,
                            97.5% 26.9%,
                            85.5% 0.1%,
                            80.7% 2%,
                            72.5% 32.5%,
                            60.2% 62.4%,
                            52.4% 68.1%,
                            47.5% 58.3%,
                            45.2% 34.5%,
                            27.5% 76.7%,
                            0.1% 64.9%,
                            17.9% 100%,
                            27.6% 76.8%,
                            76.1% 97.7%,
                            74.1% 44.1%
                        );
                    "
                />
            </div>
            <div
                class="absolute -top-52 left-1/2 -z-10 -translate-x-1/2 transform-gpu blur-3xl sm:top-[-28rem] sm:ml-16 sm:translate-x-0 sm:transform-gpu"
                aria-hidden="true"
            >
                <div
                    class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#ff4694] to-[#776fff] opacity-20"
                    style="
                        clip-path: polygon(
                            74.1% 44.1%,
                            100% 61.6%,
                            97.5% 26.9%,
                            85.5% 0.1%,
                            80.7% 2%,
                            72.5% 32.5%,
                            60.2% 62.4%,
                            52.4% 68.1%,
                            47.5% 58.3%,
                            45.2% 34.5%,
                            27.5% 76.7%,
                            0.1% 64.9%,
                            17.9% 100%,
                            27.6% 76.8%,
                            76.1% 97.7%,
                            74.1% 44.1%
                        );
                    "
                />
            </div>
            <div class="mx-auto container px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h2
                        class="text-2xl font-bold tracking-tight text-white sm:text-4xl"
                    >
                        {{ course.title }}
                    </h2>
                    <p class="mt-6 text-lg leading-8 text-gray-300">
                        {{ course.description }}
                    </p>
                </div>

                <div class="mx-auto mt-10 max-w-2xl lg:mx-0 lg:max-w-none">
                    <button
                        class="block py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600"
                        type="button"
                        @click.prevent="startLearning"
                        v-if="user"
                    >
                        Start Learning
                    </button>
                    <dl
                        class="mt-16 grid grid-cols-1 gap-8 sm:mt-20 sm:grid-cols-2 lg:grid-cols-4"
                    >
                        <div
                            v-for="stat in stats"
                            :key="stat.name"
                            class="flex flex-col-reverse"
                        >
                            <dt class="text-base leading-7 text-gray-300">
                                {{ stat.name }}
                            </dt>
                            <dd
                                class="text-2xl font-bold leading-9 tracking-tight text-white"
                            >
                                {{ stat.value }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
        <div class="mx-auto container px-6 py-14 lg:px-8">
            <div class="grid grid-cols-3 gap-6">
                <div class="col-span-2">
                    <div class="px-4 sm:px-0">
                        <h3
                            class="text-base font-semibold leading-7 text-gray-900"
                        >
                            Course Information
                        </h3>
                    </div>
                    <div class="mt-6 border-t border-gray-100">
                        <dl class="divide-y divide-gray-100">
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                            >
                                <dt
                                    class="text-sm font-medium leading-6 text-gray-900"
                                >
                                    Features
                                </dt>
                                <dd
                                    class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ course.features }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                            >
                                <dt
                                    class="text-sm font-medium leading-6 text-gray-900"
                                >
                                    Requirements
                                </dt>
                                <dd
                                    class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ course.requirements }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                            >
                                <dt
                                    class="text-sm font-medium leading-6 text-gray-900"
                                >
                                    Start date
                                </dt>
                                <dd
                                    class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    {{ course.start_date }}
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                            >
                                <dt
                                    class="text-sm font-medium leading-6 text-gray-900"
                                >
                                    Certified
                                </dt>
                                <dd
                                    class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"
                                >
                                    Yes
                                </dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                            >
                                <dt
                                    class="text-sm font-medium leading-6 text-gray-900"
                                >
                                    Subjects
                                </dt>
                                <dd
                                    class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0"
                                ></dd>
                            </div>
                            <div
                                class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0"
                            >
                                <dt
                                    class="text-sm font-medium leading-6 text-gray-900"
                                >
                                    Topics
                                </dt>
                                <dd
                                    class="mt-2 text-sm text-gray-900 sm:col-span-2 sm:mt-0"
                                >
                                    <dl
                                        class="max-w-md text-gray-900 divide-y divide-gray-200 dark:divide-gray-700"
                                    >
                                        <div
                                            class="flex flex-col pb-3"
                                            v-for="topic in course.topics"
                                            :key="topic.id"
                                        >
                                            <dt class="mb-1">
                                                {{ topic.title }}
                                            </dt>
                                            <dd class="">
                                                {{ topic.description }}
                                            </dd>
                                        </div>
                                    </dl>
                                </dd>
                            </div>
                        </dl>
                    </div>

                    <template
                        v-for="teacher in course.teachers"
                        :key="teacher.id"
                    >
                        <Instractor :user="teacher" />
                    </template>
                </div>
                <div class="col-span-1">
                    <Pricing :course="course" />
                </div>
            </div>
        </div>
    </MainLayout>
</template>
