<script setup lang="ts">
import { Course, Subject } from "@/types";
import { Head, Link } from "@inertiajs/vue3";
import { ref, onMounted, onUnmounted, computed } from "vue";
import { usePage } from "@inertiajs/vue3";
import {
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from "@headlessui/vue";
import {
    Bars3Icon,
    XMarkIcon,
    AcademicCapIcon,
    BookOpenIcon,
    ClipboardDocumentCheckIcon,
    TrophyIcon,
    UserGroupIcon,
    ChatBubbleLeftRightIcon,
    EnvelopeIcon,
    ChevronRightIcon,
    UserCircleIcon,
} from "@heroicons/vue/24/outline";

const props = defineProps<{
    subjects: Subject[];
    featuredCourses: Course[];
}>();

const page = usePage();
const user = computed(() => page.props.auth?.user);

// Mobile menu
const mobileMenuOpen = ref(false);

// Hero slides
const slides = [
    {
        heading: "Master New Skills Online",
        sub: "Learn from expert instructors with hands-on courses and real certifications",
        cta: "Explore Courses",
        ctaHref: "#courses",
    },
    {
        heading: "Earn Industry Certifications",
        sub: "Prove your expertise with recognized certificates upon completing exams",
        cta: "View Exams",
        ctaHref: "#subjects",
    },
    {
        heading: "Learn at Your Own Pace",
        sub: "Access courses and exams any time, anywhere, on any device",
        cta: "Get Started Free",
        ctaHref: "/register",
    },
];

const currentSlide = ref(0);
let slideInterval: ReturnType<typeof setInterval>;

onMounted(() => {
    slideInterval = setInterval(() => {
        currentSlide.value = (currentSlide.value + 1) % slides.length;
    }, 5000);
});

onUnmounted(() => {
    clearInterval(slideInterval);
});

// Testimonials
const testimonials = [
    {
        name: "Sarah Johnson",
        role: "Software Engineer",
        avatar: "https://i.pravatar.cc/80?img=47",
        text: "The courses here are incredibly well-structured. I landed my dream job just 3 months after completing the web development track!",
    },
    {
        name: "Michael Chen",
        role: "Data Analyst",
        avatar: "https://i.pravatar.cc/80?img=12",
        text: "The certification exams are challenging but fair. Having this certification on my resume made a huge difference in my job search.",
    },
    {
        name: "Amara Osei",
        role: "UX Designer",
        avatar: "https://i.pravatar.cc/80?img=32",
        text: "Excellent learning experience! The combination of course content and hands-on exams really helped me build practical skills.",
    },
];

// Emoji icons for subjects
const subjectEmojis = [
    "💻", "📊", "🎨", "🔬", "📱", "🌐",
    "🤖", "📈", "🎯", "⚙️", "📝", "🏆",
    "🧠", "🔐", "📡", "🖥️",
];
function getSubjectEmoji(index: number): string {
    return subjectEmojis[index % subjectEmojis.length];
}

function starsFilled(rating: number | string): number {
    return Math.round(Number(rating) || 0);
}

// Contact form
const contactForm = ref({ name: "", email: "", message: "" });
function submitContact() {
    // placeholder — wire up your controller when ready
    alert("Message sent! We'll get back to you soon.");
    contactForm.value = { name: "", email: "", message: "" };
}

// Course card helpers
function discountedPrice(course: Course): number {
    if (!course.discount || course.discount <= 0) return course.price;
    return Math.round(course.price / (1 - course.discount / 100));
}
</script>

<template>
    <div class="min-h-screen bg-white">
        <Head title="Welcome — Learn, Exam & Get Certified" />

        <!-- ===================== NAVIGATION ===================== -->
        <header class="bg-white border-b border-gray-200 sticky top-0 z-50 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">

                    <!-- Logo + Desktop Nav -->
                    <div class="flex items-center gap-8">
                        <Link :href="route('home')" class="flex-shrink-0">
                            <img src="/images/logo.svg" alt="Examinee" class="h-8 w-auto" />
                        </Link>
                        <nav class="hidden md:flex items-center space-x-1">
                            <a href="#courses"
                                class="text-gray-700 hover:text-purple-700 font-medium px-3 py-2 rounded-md text-sm transition-colors">Courses</a>
                            <a href="#subjects"
                                class="text-gray-700 hover:text-purple-700 font-medium px-3 py-2 rounded-md text-sm transition-colors">Subjects</a>
                            <a href="#certifications"
                                class="text-gray-700 hover:text-purple-700 font-medium px-3 py-2 rounded-md text-sm transition-colors">Certifications</a>
                            <a href="#contact"
                                class="text-gray-700 hover:text-purple-700 font-medium px-3 py-2 rounded-md text-sm transition-colors">Contact</a>
                        </nav>
                    </div>

                    <!-- Right actions -->
                    <div class="flex items-center gap-3">
                        <template v-if="user">
                            <Link :href="route('learning.courses')"
                                class="hidden md:block text-sm text-gray-700 hover:text-purple-700 font-medium px-3 py-2 transition-colors">
                                My Learning
                            </Link>
                            <Menu as="div" class="relative">
                                <MenuButton
                                    class="flex items-center gap-2 text-sm text-gray-700 hover:text-purple-700 font-medium px-3 py-2 rounded-full border border-gray-200 hover:border-purple-300 transition-colors">
                                    <UserCircleIcon class="h-5 w-5" />
                                    <span class="hidden sm:block max-w-[120px] truncate">{{ user.name }}</span>
                                </MenuButton>
                                <transition enter-active-class="transition ease-out duration-100"
                                    enter-from-class="transform opacity-0 scale-95"
                                    enter-to-class="transform opacity-100 scale-100"
                                    leave-active-class="transition ease-in duration-75"
                                    leave-from-class="transform opacity-100 scale-100"
                                    leave-to-class="transform opacity-0 scale-95">
                                    <MenuItems
                                        class="absolute right-0 mt-2 w-48 origin-top-right bg-white border border-gray-200 rounded-xl shadow-lg py-1 focus:outline-none">
                                        <MenuItem v-slot="{ active }">
                                        <Link :href="route('profile.edit')"
                                            :class="[active ? 'bg-gray-50' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                            Profile
                                        </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <Link :href="route('learning.courses')"
                                            :class="[active ? 'bg-gray-50' : '', 'block px-4 py-2 text-sm text-gray-700']">
                                            My Learning
                                        </Link>
                                        </MenuItem>
                                        <MenuItem v-slot="{ active }">
                                        <Link :href="route('logout')" method="post" as="button"
                                            :class="[active ? 'bg-gray-50' : '', 'w-full text-left block px-4 py-2 text-sm text-gray-700']">
                                            Log Out
                                        </Link>
                                        </MenuItem>
                                    </MenuItems>
                                </transition>
                            </Menu>
                        </template>
                        <template v-else>
                            <Link :href="route('login')"
                                class="hidden md:inline-flex text-sm font-medium text-purple-700 border border-purple-300 px-4 py-2 rounded-lg hover:bg-purple-50 transition-colors">
                                Log In
                            </Link>
                            <Link :href="route('register')"
                                class="inline-flex text-sm font-semibold text-white bg-purple-700 hover:bg-purple-800 px-4 py-2 rounded-lg transition-colors shadow-sm">
                                Sign Up Free
                            </Link>
                        </template>
                        <!-- Mobile toggle -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden p-2 rounded-lg text-gray-500 hover:bg-gray-100 transition-colors">
                            <XMarkIcon v-if="mobileMenuOpen" class="h-6 w-6" />
                            <Bars3Icon v-else class="h-6 w-6" />
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile menu -->
            <div v-show="mobileMenuOpen" class="md:hidden border-t border-gray-100 bg-white px-4 py-3 space-y-1">
                <a href="#courses" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-md">Courses</a>
                <a href="#subjects" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-md">Subjects</a>
                <a href="#certifications" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-md">Certifications</a>
                <a href="#contact" @click="mobileMenuOpen = false"
                    class="block px-3 py-2 text-sm font-medium text-gray-700 hover:bg-purple-50 hover:text-purple-700 rounded-md">Contact</a>
                <div class="pt-2 border-t border-gray-100 flex gap-2" v-if="!user">
                    <Link :href="route('login')"
                        class="flex-1 text-center text-sm font-medium text-purple-700 border border-purple-300 px-4 py-2 rounded-lg">
                        Log In
                    </Link>
                    <Link :href="route('register')"
                        class="flex-1 text-center text-sm font-semibold text-white bg-purple-700 px-4 py-2 rounded-lg">
                        Sign Up
                    </Link>
                </div>
            </div>
        </header>

        <!-- ===================== HERO SECTION ===================== -->
        <section
            class="relative bg-gradient-to-br from-purple-950 via-indigo-900 to-blue-900 text-white overflow-hidden">
            <!-- Decorative blobs -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div
                    class="absolute -top-20 -left-20 w-96 h-96 bg-purple-500 rounded-full opacity-10 blur-3xl animate-pulse">
                </div>
                <div
                    class="absolute -bottom-10 -right-20 w-[500px] h-[500px] bg-indigo-400 rounded-full opacity-10 blur-3xl">
                </div>
            </div>

            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 lg:py-32">
                <!-- Slide transition area -->
                <transition name="hero-fade" mode="out-in">
                    <div :key="currentSlide" class="max-w-3xl">
                        <div
                            class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm rounded-full px-4 py-1.5 text-sm text-purple-200 font-medium mb-6 border border-white/20">
                            <AcademicCapIcon class="h-4 w-4 flex-shrink-0" />
                            <span>Trusted by 10,000+ learners worldwide</span>
                        </div>
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight tracking-tight mb-6">
                            {{ slides[currentSlide].heading }}
                        </h1>
                        <p class="text-xl text-purple-100 mb-10 leading-relaxed max-w-2xl">
                            {{ slides[currentSlide].sub }}
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a :href="slides[currentSlide].ctaHref"
                                class="inline-flex items-center gap-2 bg-white text-purple-900 font-bold px-8 py-4 rounded-xl hover:bg-purple-50 transition-colors shadow-lg text-lg">
                                {{ slides[currentSlide].cta }}
                                <ChevronRightIcon class="h-5 w-5" />
                            </a>
                            <a href="#courses"
                                class="inline-flex items-center gap-2 border-2 border-white/40 text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/10 transition-colors text-lg">
                                Browse All Courses
                            </a>
                        </div>
                    </div>
                </transition>

                <!-- Slide indicators -->
                <div class="flex gap-2 mt-12">
                    <button v-for="(_, i) in slides" :key="i" @click="currentSlide = i"
                        :class="['h-2.5 rounded-full transition-all duration-300', currentSlide === i ? 'bg-white w-8' : 'bg-white/40 w-2.5']"
                        :aria-label="`Slide ${i + 1}`">
                    </button>
                </div>
            </div>

            <!-- Stats bar -->
            <div class="relative border-t border-white/10 bg-white/5 backdrop-blur-sm">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
                        <div>
                            <div class="text-3xl font-bold text-white">500+</div>
                            <div class="text-purple-200 text-sm mt-1">Courses Available</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white">10K+</div>
                            <div class="text-purple-200 text-sm mt-1">Active Students</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white">200+</div>
                            <div class="text-purple-200 text-sm mt-1">Exams &amp; Tests</div>
                        </div>
                        <div>
                            <div class="text-3xl font-bold text-white">98%</div>
                            <div class="text-purple-200 text-sm mt-1">Satisfaction Rate</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== FEATURED COURSES ===================== -->
        <section id="courses" class="py-20 bg-gray-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-end justify-between mb-10">
                    <div>
                        <span
                            class="text-purple-700 font-semibold text-sm uppercase tracking-wider">Featured</span>
                        <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-1">Top Courses to Get You
                            Started</h2>
                    </div>
                    <a href="#subjects"
                        class="hidden md:inline-flex items-center gap-1 text-purple-700 font-semibold hover:text-purple-900 transition-colors text-sm">
                        View all <ChevronRightIcon class="h-4 w-4" />
                    </a>
                </div>

                <!-- 2-row grid of 4 columns = 8 cards -->
                <div v-if="featuredCourses && featuredCourses.length"
                    class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div v-for="course in featuredCourses.slice(0, 8)" :key="course.id"
                        class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden group border border-gray-100 flex flex-col">
                        <!-- Thumbnail -->
                        <div
                            class="relative h-44 bg-gradient-to-br from-purple-100 to-indigo-100 overflow-hidden flex-shrink-0">
                            <img v-if="course.thumbnail" :src="course.thumbnail" :alt="course.title"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" />
                            <div v-else class="w-full h-full flex items-center justify-center">
                                <BookOpenIcon class="h-14 w-14 text-purple-300" />
                            </div>
                            <div v-if="course.certified"
                                class="absolute top-3 left-3 bg-amber-400 text-amber-900 text-xs font-bold px-2 py-0.5 rounded-full">
                                CERTIFIED
                            </div>
                            <div v-if="course.discount && course.discount > 0"
                                class="absolute top-3 right-3 bg-red-500 text-white text-xs font-bold px-2 py-0.5 rounded-full">
                                {{ course.discount }}% OFF
                            </div>
                        </div>

                        <!-- Card body -->
                        <div class="p-4 flex flex-col flex-1">
                            <h3
                                class="font-semibold text-gray-900 text-sm leading-snug line-clamp-2 mb-1 group-hover:text-purple-700 transition-colors">
                                {{ course.title }}
                            </h3>
                            <p v-if="course.subtitle" class="text-xs text-gray-500 line-clamp-1 mb-2">
                                {{ course.subtitle }}
                            </p>

                            <!-- Rating -->
                            <div v-if="course.rating" class="flex items-center gap-1 mb-2">
                                <span class="text-amber-500 font-bold text-xs">{{ Number(course.rating).toFixed(1)
                                    }}</span>
                                <div class="flex gap-0.5">
                                    <span v-for="i in 5" :key="i"
                                        :class="['text-sm', i <= starsFilled(Number(course.rating)) ? 'text-amber-400' : 'text-gray-200']">★</span>
                                </div>
                                <span class="text-xs text-gray-500">({{ course.students_count ?? 0
                                    }})</span>
                            </div>

                            <!-- Lesson count -->
                            <div v-if="course.lessons_count"
                                class="flex items-center gap-1 text-xs text-gray-500 mb-3">
                                <BookOpenIcon class="h-3.5 w-3.5" />
                                <span>{{ course.lessons_count }} lessons</span>
                            </div>

                            <!-- Price & CTA -->
                            <div class="mt-auto flex items-center justify-between gap-2">
                                <div class="flex items-baseline gap-1">
                                    <span class="text-base font-bold text-gray-900">${{ course.price }}</span>
                                    <span v-if="course.discount && course.discount > 0"
                                        class="text-xs text-gray-400 line-through">${{ discountedPrice(course)
                                        }}</span>
                                </div>
                                <Link :href="course.permalink"
                                    class="flex-shrink-0 text-xs font-semibold text-white bg-purple-700 hover:bg-purple-800 px-3 py-1.5 rounded-lg transition-colors">
                                    Enroll
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty state -->
                <div v-else class="text-center py-16 text-gray-400">
                    <BookOpenIcon class="h-12 w-12 mx-auto mb-3 text-gray-300" />
                    <p class="text-lg font-medium text-gray-500">Courses coming soon!</p>
                    <p class="text-sm mt-1">We're preparing great content for you. Check back shortly.</p>
                </div>
            </div>
        </section>

        <!-- ===================== OFFER / CTA BLOCK ===================== -->
        <section id="certifications"
            class="py-20 bg-gradient-to-r from-purple-800 via-purple-900 to-indigo-900">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid lg:grid-cols-2 gap-16 items-center">
                    <!-- Left: copy -->
                    <div>
                        <h2 class="text-3xl lg:text-4xl font-bold text-white leading-tight mb-4">
                            Ready to Start Your Learning Journey?
                        </h2>
                        <p class="text-purple-200 text-lg mb-8 leading-relaxed">
                            Join thousands of students already building skills on our platform. Get unlimited access
                            to courses, sit exams, and earn certifications that advance your career.
                        </p>
                        <ul class="space-y-3 mb-10">
                            <li v-for="benefit in [
                                'Lifetime access to all enrolled courses',
                                'Industry-recognized certifications',
                                'Expert-crafted exams with detailed feedback',
                                'Learn at your own schedule, on any device',
                            ]" :key="benefit" class="flex items-center gap-3 text-white text-sm">
                                <span
                                    class="flex-shrink-0 w-5 h-5 bg-white/20 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                                {{ benefit }}
                            </li>
                        </ul>
                        <div class="flex flex-wrap gap-4">
                            <Link :href="route('register')"
                                class="inline-flex items-center gap-2 bg-white text-purple-900 font-bold px-8 py-4 rounded-xl hover:bg-purple-50 transition-colors shadow-lg text-base">
                                Get Started Free
                                <ChevronRightIcon class="h-5 w-5" />
                            </Link>
                            <a href="#courses"
                                class="inline-flex items-center gap-2 border-2 border-white/40 text-white font-semibold px-8 py-4 rounded-xl hover:bg-white/10 transition-colors text-base">
                                Browse Courses
                            </a>
                        </div>
                    </div>

                    <!-- Right: feature cards -->
                    <div class="hidden lg:grid grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div
                                class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-colors">
                                <AcademicCapIcon class="h-10 w-10 text-purple-200 mb-3" />
                                <h3 class="text-white font-semibold mb-1">Guided Courses</h3>
                                <p class="text-purple-200 text-sm">Structured learning paths curated by experts</p>
                            </div>
                            <div
                                class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-colors">
                                <UserGroupIcon class="h-10 w-10 text-purple-200 mb-3" />
                                <h3 class="text-white font-semibold mb-1">Community</h3>
                                <p class="text-purple-200 text-sm">Learn together with thousands of peers</p>
                            </div>
                        </div>
                        <div class="space-y-4 mt-8">
                            <div
                                class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-colors">
                                <ClipboardDocumentCheckIcon class="h-10 w-10 text-purple-200 mb-3" />
                                <h3 class="text-white font-semibold mb-1">Smart Exams</h3>
                                <p class="text-purple-200 text-sm">Test your skills with detailed analytics</p>
                            </div>
                            <div
                                class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20 hover:bg-white/15 transition-colors">
                                <TrophyIcon class="h-10 w-10 text-purple-200 mb-3" />
                                <h3 class="text-white font-semibold mb-1">Certificates</h3>
                                <p class="text-purple-200 text-sm">Earn industry-recognized certifications</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== SUBJECTS ===================== -->
        <section id="subjects" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-purple-700 font-semibold text-sm uppercase tracking-wider">Explore</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-1">Subjects We Offer</h2>
                    <p class="text-gray-500 mt-3 max-w-xl mx-auto text-base">Choose from a wide range of subjects
                        and start learning what matters most to your career</p>
                </div>

                <div v-if="subjects && subjects.length"
                    class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-4">
                    <div v-for="(subject, index) in subjects" :key="subject.id"
                        class="group flex flex-col items-center text-center p-5 rounded-2xl border border-gray-100 hover:border-purple-200 hover:shadow-md hover:bg-purple-50 transition-all duration-200 cursor-pointer">
                        <div class="text-4xl mb-3 group-hover:scale-110 transition-transform duration-200">{{
                            getSubjectEmoji(index) }}</div>
                        <h3 class="text-gray-800 font-semibold text-sm leading-snug mb-1">{{ subject.title }}</h3>
                        <span class="text-xs text-purple-600 font-medium">
                            {{ subject.courses_count ?? (subject.courses?.length ?? 0) }} Courses
                        </span>
                    </div>
                </div>

                <div v-else class="text-center py-12 text-gray-400">
                    <p class="text-base">No subjects available yet — check back soon!</p>
                </div>
            </div>
        </section>

        <!-- ===================== TESTIMONIALS ===================== -->
        <section class="py-20 bg-gradient-to-b from-gray-50 to-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-purple-700 font-semibold text-sm uppercase tracking-wider">Testimonials</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-1">What Our Students Say</h2>
                    <p class="text-gray-500 mt-3 max-w-xl mx-auto text-base">Real stories from real learners who
                        transformed their careers with our platform</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div v-for="t in testimonials" :key="t.name"
                        class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 hover:shadow-lg transition-shadow duration-300 flex flex-col">
                        <!-- Stars -->
                        <div class="flex gap-0.5 mb-4">
                            <span v-for="i in 5" :key="i" class="text-amber-400 text-xl">★</span>
                        </div>
                        <!-- Quote -->
                        <p class="text-gray-700 leading-relaxed mb-6 italic flex-1">"{{ t.text }}"</p>
                        <!-- Author -->
                        <div class="flex items-center gap-3">
                            <img :src="t.avatar" :alt="t.name"
                                class="w-12 h-12 rounded-full object-cover border-2 border-purple-100"
                                loading="lazy" />
                            <div>
                                <div class="font-semibold text-gray-900 text-sm">{{ t.name }}</div>
                                <div class="text-purple-600 text-xs">{{ t.role }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== CONTACT & CHAT ===================== -->
        <section id="contact" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <span class="text-purple-700 font-semibold text-sm uppercase tracking-wider">Get In
                        Touch</span>
                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mt-1">Contact &amp; Support</h2>
                    <p class="text-gray-500 mt-3 max-w-xl mx-auto text-base">Have a question? We're here to help
                        you every step of the way</p>
                </div>

                <div class="grid lg:grid-cols-2 gap-16 items-start">
                    <!-- Contact form -->
                    <div class="bg-gray-50 rounded-3xl p-8 border border-gray-100">
                        <h3 class="text-xl font-bold text-gray-900 mb-6">Send us a Message</h3>
                        <form @submit.prevent="submitContact" class="space-y-5">
                            <div class="grid sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Your
                                        Name</label>
                                    <input v-model="contactForm.name" type="text" placeholder="John Doe"
                                        required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-sm transition-all" />
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Email
                                        Address</label>
                                    <input v-model="contactForm.email" type="email"
                                        placeholder="john@example.com" required
                                        class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-sm transition-all" />
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1.5">Message</label>
                                <textarea v-model="contactForm.message"
                                    placeholder="Tell us how we can help you..." rows="5" required
                                    class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent bg-white text-sm resize-none transition-all"></textarea>
                            </div>
                            <button type="submit"
                                class="w-full bg-purple-700 hover:bg-purple-800 text-white font-semibold py-3.5 rounded-xl transition-colors shadow-sm">
                                Send Message
                            </button>
                        </form>
                    </div>

                    <!-- Chat & support cards -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">We're Always Here</h3>
                            <p class="text-gray-500 leading-relaxed">Whether you have questions about a course,
                                exam, or certification — our team is ready to help you succeed.</p>
                        </div>

                        <div class="space-y-4">
                            <div
                                class="flex items-start gap-4 p-5 rounded-2xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50 transition-colors">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <ChatBubbleLeftRightIcon class="h-6 w-6 text-purple-700" />
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Live Chat Support</h4>
                                    <p class="text-sm text-gray-500 mt-0.5">Chat with our team in real-time</p>
                                    <span
                                        class="inline-flex items-center gap-1 text-xs text-green-600 font-medium mt-1">
                                        <span class="w-2 h-2 bg-green-400 rounded-full"></span>Online now
                                    </span>
                                </div>
                            </div>

                            <div
                                class="flex items-start gap-4 p-5 rounded-2xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50 transition-colors">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <EnvelopeIcon class="h-6 w-6 text-purple-700" />
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">Email Support</h4>
                                    <p class="text-sm text-gray-500 mt-0.5">support@examinee.com</p>
                                    <p class="text-xs text-gray-400 mt-1">Response within 24 hours</p>
                                </div>
                            </div>

                            <div
                                class="flex items-start gap-4 p-5 rounded-2xl border border-gray-100 hover:border-purple-200 hover:bg-purple-50 transition-colors">
                                <div
                                    class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <AcademicCapIcon class="h-6 w-6 text-purple-700" />
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">FAQ &amp; Help Center</h4>
                                    <p class="text-sm text-gray-500 mt-0.5">Browse our detailed knowledge base
                                    </p>
                                    <a href="#"
                                        class="text-xs text-purple-600 font-medium mt-1 inline-flex items-center gap-1 hover:text-purple-800 transition-colors">
                                        Visit Help Center <ChevronRightIcon class="h-3.5 w-3.5" />
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- ===================== FOOTER ===================== -->
        <footer class="bg-gray-950 text-gray-400">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-10">
                    <!-- Brand col -->
                    <div class="lg:col-span-2">
                        <Link :href="route('home')"
                            class="inline-block brightness-0 invert mb-4">
                            <img src="/images/logo.svg" alt="Examinee" class="h-8 w-auto" />
                        </Link>
                        <p class="text-sm leading-relaxed mb-6">Empower your future with expert-led courses,
                            certification exams, and a community of passionate learners.</p>
                        <!-- Social -->
                        <div class="flex gap-3">
                            <a href="#"
                                class="w-9 h-9 bg-gray-800 hover:bg-purple-700 rounded-lg flex items-center justify-center transition-colors"
                                aria-label="Twitter / X">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-4.714-6.231-5.401 6.231H2.748l7.73-8.835L1.254 2.25H8.08l4.253 5.622zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-9 h-9 bg-gray-800 hover:bg-purple-700 rounded-lg flex items-center justify-center transition-colors"
                                aria-label="LinkedIn">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.064 2.064 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                                </svg>
                            </a>
                            <a href="#"
                                class="w-9 h-9 bg-gray-800 hover:bg-purple-700 rounded-lg flex items-center justify-center transition-colors"
                                aria-label="YouTube">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Courses -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Courses</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#courses" class="hover:text-purple-400 transition-colors">All
                                    Courses</a></li>
                            <li><a href="#courses" class="hover:text-purple-400 transition-colors">Featured
                                    Courses</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Free Courses</a>
                            </li>
                            <li><a href="#certifications"
                                    class="hover:text-purple-400 transition-colors">Certifications</a></li>
                        </ul>
                    </div>

                    <!-- Platform -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Platform</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#" class="hover:text-purple-400 transition-colors">About Us</a></li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">How It Works</a>
                            </li>
                            <li><a href="#contact" class="hover:text-purple-400 transition-colors">Contact
                                    Us</a></li>
                            <li>
                                <Link :href="route('register')"
                                    class="hover:text-purple-400 transition-colors">Sign Up
                                </Link>
                            </li>
                        </ul>
                    </div>

                    <!-- Legal -->
                    <div>
                        <h4 class="text-white font-semibold mb-4">Legal</h4>
                        <ul class="space-y-3 text-sm">
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Privacy Policy</a>
                            </li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Terms of Service</a>
                            </li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Cookie Policy</a>
                            </li>
                            <li><a href="#" class="hover:text-purple-400 transition-colors">Refund Policy</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom bar -->
                <div
                    class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <p class="text-sm">© {{ new Date().getFullYear() }} Examinee. All rights reserved.</p>
                    <p class="text-sm">Made with ❤️ for lifelong learners</p>
                </div>
            </div>
        </footer>
    </div>
</template>

<style scoped>
/* Hero slide transition */
.hero-fade-enter-active {
    transition: opacity 0.5s ease, transform 0.5s ease;
}

.hero-fade-leave-active {
    transition: opacity 0.3s ease, transform 0.3s ease;
}

.hero-fade-enter-from {
    opacity: 0;
    transform: translateY(16px);
}

.hero-fade-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}

/* Tailwind line-clamp fallback */
.line-clamp-1 {
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
