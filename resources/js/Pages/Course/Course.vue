<script setup lang="ts">
import { Head, Link, usePage } from "@inertiajs/vue3";
import MainLayout from "@/Layouts/MainLayout.vue";
import { PaperClipIcon } from "@heroicons/vue/20/solid";
import { computed } from "vue";

const page = usePage();

const user = computed(() => page.props.auth.user);

const props = defineProps<{
    course: any;
}>();

const stats = [
    { name: "Number of student", value: props.course.students_count },
    { name: "Number of sessions", value: props.course.sessions_count },
    { name: "Number of exams", value: props.course.exams_count },
    { name: "Number of lessons", value: props.course.lessons_count },
];

function startLearning() {
    if (!user) {
        return;
    }
    if (this.loading) {
        return;
    }

    this.loading = true;

    axios
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
            this.loading = false;
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
                    <Link
                        class="block py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600"
                        as="button"
                        @click.prevent="startLearning"
                        v-if="user"
                    >
                        Start Learning
                    </Link>
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

                    <!-- User Profile Tab Card -->
                    <div
                        class="flex flex-row rounded-lg border border-gray-200/80 bg-white p-6"
                    >
                        <!-- Avaar Container -->
                        <div class="relative">
                            <!-- User Avatar -->
                            <img
                                class="w-40 h-40 rounded-md object-cover"
                                src="https://png.pngtree.com/png-vector/20220709/ourmid/pngtree-businessman-user-avatar-wearing-suit-with-red-tie-png-image_5809521.png"
                                alt="User"
                            />

                            <!-- Online Status Dot -->
                            <div
                                class="absolute -right-3 bottom-5 h-5 w-5 sm:top-2 rounded-full border-4 border-white bg-green-400 sm:invisible md:visible"
                                title="User is online"
                            ></div>
                        </div>

                        <!-- Meta Body -->
                        <div class="flex flex-col overflow-hidden px-6">
                            <!-- Username Container -->
                            <div class="flex h-8 flex-row">
                                <!-- Username -->
                                <a
                                    href="https://github.com/EgoistDeveloper/"
                                    target="_blank"
                                >
                                    <h2 class="text-lg font-semibold">
                                        EgoistDeveloper
                                    </h2>
                                </a>

                                <!-- User Verified -->
                                <svg
                                    class="my-auto ml-2 h-5 fill-blue-400"
                                    xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink"
                                    version="1.1"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"
                                    />
                                </svg>
                            </div>

                            <!-- Meta Badges -->
                            <div class="my-2 flex flex-row space-x-2">
                                <!-- Badge Role -->
                                <div class="flex flex-row">
                                    <svg
                                        class="mr-2 h-4 w-4 fill-gray-500/80"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M7.07,18.28C7.5,17.38 10.12,16.5 12,16.5C13.88,16.5 16.5,17.38 16.93,18.28C15.57,19.36 13.86,20 12,20C10.14,20 8.43,19.36 7.07,18.28M18.36,16.83C16.93,15.09 13.46,14.5 12,14.5C10.54,14.5 7.07,15.09 5.64,16.83C4.62,15.5 4,13.82 4,12C4,7.59 7.59,4 12,4C16.41,4 20,7.59 20,12C20,13.82 19.38,15.5 18.36,16.83M12,6C10.06,6 8.5,7.56 8.5,9.5C8.5,11.44 10.06,13 12,13C13.94,13 15.5,11.44 15.5,9.5C15.5,7.56 13.94,6 12,6M12,11A1.5,1.5 0 0,1 10.5,9.5A1.5,1.5 0 0,1 12,8A1.5,1.5 0 0,1 13.5,9.5A1.5,1.5 0 0,1 12,11Z"
                                        />
                                    </svg>

                                    <div
                                        class="text-xs text-gray-400/80 hover:text-gray-400"
                                    >
                                        Fullstack Developer
                                    </div>
                                </div>

                                <!-- Badge Location -->
                                <div class="flex flex-row">
                                    <svg
                                        class="mr-2 h-4 w-4 fill-gray-500/80"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5M12,2A7,7 0 0,1 19,9C19,14.25 12,22 12,22C12,22 5,14.25 5,9A7,7 0 0,1 12,2M12,4A5,5 0 0,0 7,9C7,10 7,12 12,18.71C17,12 17,10 17,9A5,5 0 0,0 12,4Z"
                                        />
                                    </svg>

                                    <div
                                        class="text-xs text-gray-400/80 hover:text-gray-400"
                                    >
                                        Istanbul
                                    </div>
                                </div>

                                <!-- Badge Email-->
                                <div class="flex flex-row">
                                    <svg
                                        class="mr-2 h-4 w-4 fill-gray-500/80"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12,15C12.81,15 13.5,14.7 14.11,14.11C14.7,13.5 15,12.81 15,12C15,11.19 14.7,10.5 14.11,9.89C13.5,9.3 12.81,9 12,9C11.19,9 10.5,9.3 9.89,9.89C9.3,10.5 9,11.19 9,12C9,12.81 9.3,13.5 9.89,14.11C10.5,14.7 11.19,15 12,15M12,2C14.75,2 17.1,3 19.05,4.95C21,6.9 22,9.25 22,12V13.45C22,14.45 21.65,15.3 21,16C20.3,16.67 19.5,17 18.5,17C17.3,17 16.31,16.5 15.56,15.5C14.56,16.5 13.38,17 12,17C10.63,17 9.45,16.5 8.46,15.54C7.5,14.55 7,13.38 7,12C7,10.63 7.5,9.45 8.46,8.46C9.45,7.5 10.63,7 12,7C13.38,7 14.55,7.5 15.54,8.46C16.5,9.45 17,10.63 17,12V13.45C17,13.86 17.16,14.22 17.46,14.53C17.76,14.84 18.11,15 18.5,15C18.92,15 19.27,14.84 19.57,14.53C19.87,14.22 20,13.86 20,13.45V12C20,9.81 19.23,7.93 17.65,6.35C16.07,4.77 14.19,4 12,4C9.81,4 7.93,4.77 6.35,6.35C4.77,7.93 4,9.81 4,12C4,14.19 4.77,16.07 6.35,17.65C7.93,19.23 9.81,20 12,20H17V22H12C9.25,22 6.9,21 4.95,19.05C3,17.1 2,14.75 2,12C2,9.25 3,6.9 4.95,4.95C6.9,3 9.25,2 12,2Z"
                                        />
                                    </svg>

                                    <div
                                        class="text-xs text-gray-400/80 hover:text-gray-400"
                                    >
                                        who@am.i
                                    </div>
                                </div>
                            </div>

                            <!-- Mini Cards -->
                            <div
                                class="mt-2 flex flex-row items-center space-x-5"
                            >
                                <!-- Comments -->
                                <a
                                    href="#"
                                    class="flex h-20 w-40 flex-col items-center justify-center rounded-md border border-dashed border-gray-200 transition-colors duration-100 ease-in-out hover:border-gray-400/80"
                                >
                                    <div
                                        class="flex flex-row items-center justify-center"
                                    >
                                        <svg
                                            class="mr-3 fill-gray-500/95"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            version="1.1"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M12,23A1,1 0 0,1 11,22V19H7A2,2 0 0,1 5,17V7A2,2 0 0,1 7,5H21A2,2 0 0,1 23,7V17A2,2 0 0,1 21,19H16.9L13.2,22.71C13,22.89 12.76,23 12.5,23H12M13,17V20.08L16.08,17H21V7H7V17H13M3,15H1V3A2,2 0 0,1 3,1H19V3H3V15M9,9H19V11H9V9M9,13H17V15H9V13Z"
                                            />
                                        </svg>

                                        <span class="font-bold text-gray-600">
                                            4.6K
                                        </span>
                                    </div>

                                    <div class="mt-2 text-sm text-gray-400">
                                        Comments
                                    </div>
                                </a>

                                <!-- Projects -->
                                <a
                                    href="#"
                                    class="flex h-20 w-40 flex-col items-center justify-center rounded-md border border-dashed border-gray-200 transition-colors duration-100 ease-in-out hover:border-gray-400/80"
                                >
                                    <div
                                        class="flex flex-row items-center justify-center"
                                    >
                                        <svg
                                            class="mr-3 fill-gray-500/95"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            version="1.1"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M2.5 19.6L3.8 20.2V11.2L1.4 17C1 18.1 1.5 19.2 2.5 19.6M15.2 4.8L20.2 16.8L12.9 19.8L7.9 7.9V7.8L15.2 4.8M15.3 2.8C15 2.8 14.8 2.8 14.5 2.9L7.1 6C6.4 6.3 5.9 7 5.9 7.8C5.9 8 5.9 8.3 6 8.6L11 20.5C11.3 21.3 12 21.7 12.8 21.7C13.1 21.7 13.3 21.7 13.6 21.6L21 18.5C22 18.1 22.5 16.9 22.1 15.9L17.1 4C16.8 3.2 16 2.8 15.3 2.8M10.5 9.9C9.9 9.9 9.5 9.5 9.5 8.9S9.9 7.9 10.5 7.9C11.1 7.9 11.5 8.4 11.5 8.9S11.1 9.9 10.5 9.9M5.9 19.8C5.9 20.9 6.8 21.8 7.9 21.8H9.3L5.9 13.5V19.8Z"
                                            />
                                        </svg>

                                        <span class="font-bold text-gray-600">
                                            45
                                        </span>
                                    </div>

                                    <div class="mt-2 text-sm text-gray-400">
                                        Projects
                                    </div>
                                </a>

                                <!-- Projects -->
                                <a
                                    href="#"
                                    class="flex h-20 w-40 flex-col items-center justify-center rounded-md border border-dashed border-gray-200 transition-colors duration-100 ease-in-out hover:border-gray-400/80"
                                >
                                    <div
                                        class="flex flex-row items-center justify-center"
                                    >
                                        <svg
                                            class="mr-3 fill-gray-500/95"
                                            xmlns="http://www.w3.org/2000/svg"
                                            xmlns:xlink="http://www.w3.org/1999/xlink"
                                            version="1.1"
                                            width="24"
                                            height="24"
                                            viewBox="0 0 24 24"
                                        >
                                            <path
                                                d="M5.68,19.74C7.16,20.95 9,21.75 11,21.95V19.93C9.54,19.75 8.21,19.17 7.1,18.31M13,19.93V21.95C15,21.75 16.84,20.95 18.32,19.74L16.89,18.31C15.79,19.17 14.46,19.75 13,19.93M18.31,16.9L19.74,18.33C20.95,16.85 21.75,15 21.95,13H19.93C19.75,14.46 19.17,15.79 18.31,16.9M15,12A3,3 0 0,0 12,9A3,3 0 0,0 9,12A3,3 0 0,0 12,15A3,3 0 0,0 15,12M4.07,13H2.05C2.25,15 3.05,16.84 4.26,18.32L5.69,16.89C4.83,15.79 4.25,14.46 4.07,13M5.69,7.1L4.26,5.68C3.05,7.16 2.25,9 2.05,11H4.07C4.25,9.54 4.83,8.21 5.69,7.1M19.93,11H21.95C21.75,9 20.95,7.16 19.74,5.68L18.31,7.1C19.17,8.21 19.75,9.54 19.93,11M18.32,4.26C16.84,3.05 15,2.25 13,2.05V4.07C14.46,4.25 15.79,4.83 16.9,5.69M11,4.07V2.05C9,2.25 7.16,3.05 5.68,4.26L7.1,5.69C8.21,4.83 9.54,4.25 11,4.07Z"
                                            />
                                        </svg>

                                        <span class="font-bold text-gray-600">
                                            120K
                                        </span>
                                    </div>

                                    <div class="mt-2 text-sm text-gray-400">
                                        Downloads
                                    </div>
                                </a>
                            </div>
                        </div>

                        <!-- Right Actions Container -->
                        <div
                            class="w-100 flex flex-grow flex-col items-end justify-start"
                        >
                            <div class="flex flex-row space-x-3">
                                <!-- Follow Button -->
                                <button
                                    class="flex rounded-md bg-blue-500 py-2 px-4 text-white transition-all duration-150 ease-in-out hover:bg-blue-600"
                                >
                                    <svg
                                        class="mr-2 fill-current"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z"
                                        />
                                    </svg>

                                    Follow
                                </button>

                                <!-- More Actions Button -->
                                <button
                                    class="flex rounded-md bg-gray-100 py-2 px-1 text-white transition-all duration-150 ease-in-out hover:bg-gray-200"
                                >
                                    <svg
                                        class="fill-gray-500"
                                        xmlns="http://www.w3.org/2000/svg"
                                        xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1"
                                        width="24"
                                        height="24"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            d="M12,16A2,2 0 0,1 14,18A2,2 0 0,1 12,20A2,2 0 0,1 10,18A2,2 0 0,1 12,16M12,10A2,2 0 0,1 14,12A2,2 0 0,1 12,14A2,2 0 0,1 10,12A2,2 0 0,1 12,10M12,4A2,2 0 0,1 14,6A2,2 0 0,1 12,8A2,2 0 0,1 10,6A2,2 0 0,1 12,4Z"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-span-1">
                    <div
                        class="bg-gray-800 rounded-lg shadow-lg p-6 transform hover:scale-105 transition duration-300"
                    >
                        <div class="mb-8">
                            <h3 class="text-2xl font-semibold text-white">
                                Pro
                            </h3>
                            <p class="mt-4 text-gray-400">
                                Ideal for growing businesses and enterprises.
                            </p>
                        </div>
                        <div class="mb-8">
                            <span class="text-5xl font-extrabold text-white"
                                >${{ course.price }}</span
                            >
                        </div>
                        <h3 class="text-2xl text-white">
                            This course includes:
                        </h3>
                        <ul class="mb-8 space-y-4 text-gray-400">
                            <li class="flex items-center">
                                <svg
                                    class="h-6 w-6 text-green-500 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                <span>9.5 hours on-demand video</span>
                            </li>
                            <li class="flex items-center">
                                <svg
                                    class="h-6 w-6 text-green-500 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                <span>95 downloadable resources</span>
                            </li>
                            <li class="flex items-center">
                                <svg
                                    class="h-6 w-6 text-green-500 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                <span>Access on mobile and TV</span>
                            </li>
                            <li class="flex items-center">
                                <svg
                                    class="h-6 w-6 text-green-500 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                <span>Full lifetime access</span>
                            </li>
                            <li class="flex items-center">
                                <svg
                                    class="h-6 w-6 text-green-500 mr-2"
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M5 13l4 4L19 7"
                                    />
                                </svg>
                                <span>Certificate of completion</span>
                            </li>
                        </ul>
                        <Link
                            class="block w-full py-3 px-6 text-center rounded-md text-white font-medium bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600"
                            as="button"
                            @click.prevent="startLearning"
                            v-if="user"
                        >
                            Start Learning
                        </Link>
                    </div>
                </div>
            </div>
        </div>
    </MainLayout>
</template>
