export interface User {
    id: number;
    name: string;
    firstname?: string;
    lastname?: string;
    full_name?: string;
    avatar?: string;
    email: string;
    email_verified_at: string;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string;
    roles?: Role[];
    results?: Result[];
    instructCourses?: Course[];
    enrolledCourses?: Course[];
}

export interface Student {
    id: number;
    name: string;
    full_name?: string;
    avatar?: string;
    rating: number;
    progress: number;
}

export interface Role {
    id: number;
    name: string;
    guard_name: string;
    permissions: Array
}

export interface Topic {
    id: number;
    title: string;
    description: string;
    created_at?: string;
    updated_at?: string;
    courses?: Course[];
    exams?: Exam[];
    courses_count?: number;
    exams_count?: number;
}
export interface Section {
    id: number;
    title: string;
    description: string;
    created_at?: string;
    updated_at?: string;
    exams?: Exam[];
    lessons?: Lesson[];
}
export interface Result {
    id: number;
    answers: string;
    obtain_mark: number;
    is_pass: boolean;
    time_taken: string;
    created_at?: string;
    updated_at?: string;
    examinee?: User;
    exam?: any;
}
export interface QuestionOption {
    option: string;
    id?: string;
    answer?: boolean;
}
export interface Question {
    id: number;
    qtype: string;
    question?: string;
    options?: QuestionOption[];
    answers?: Array;
    hint?: string;
    explanation?: string;
    mark?: number;
    nmark?: number;
    created_at?: string;
    updated_at?: string;
    topics?: Topic[];
    exam?: any;
}

export interface Lesson {
    id: number;
    title: string;
    slug: string;
    thumbnail?: string;
    type?: string;
    object?: string;
    short_text?: string;
    full_text?: string;
    position?: string;
    status?: string;
    created_at?: string;
    updated_at?: string;
    courses?: Course[];
    students?: User[];
    examSessions?: any;
}
export interface File {
    id: number;
    name: string;
    path?: string;
    description?: string;
    file_name?: string;
    extension?: string;
    mime?: string;
    type?: string;
    public_path?: string;
    parent_id?: string;
    uploaded_by?: any;
    created_at?: string;
    updated_at?: string;
}
export interface Subject {
    id: number;
    title: string;
    slug: string;
    description?: string;
    created_at?: string;
    updated_at?: string;
    courses?: Course[];
    exams?: Exam[];
    courses_count?: number;
    exams_count?: number;
}

export interface Exam {
    id: number;
    title: string;
    description?: string;
    status?: number;
    price?: number;
    duration?: number;
    pass_mark?: number;
    number_of_questions?: number;
    random_questions?: boolean;
    certification?: boolean;
    difficulty?: string;
    permalink?: string;
    meta?: any;
    subjects?: Subject[];
    courses?: Course[];
    questions?: Question[];
    examiner?: User;
    topics: Topic[];
    results?: Result[];
}

export interface Course {
    id: number;
    title: string;
    subtitle: string;
    slug: string;
    description?: string;
    requirements?: string;
    status?: number;
    thumbnail?: string;
    start_date?: string;
    features?: string;
    rating?: number;
    certified?: boolean;
    created_at?: string;
    updated_at?: string;
    price: number;
    discount: number;
    permalink: string;
    teachers?: User[];
    students?: User[];
    examSessions?: Section[];
    lessons?: Lesson[];
    exams?: Exam[];
    topics?: Topic[];
    subjects?: Subject[];
    lessons_count?: number;
    students_count?: number;
    sections_count?: number;
    exams_count?: number;
}

export interface LinkType {
    name: string;
    href: string;
    current: boolean;
    icon?: string;
}

export interface JsonResponse<T> {
    data: T;
    links: {
        fast: string;
        last: string;
        prev?: string;
        next?: string;
    },
    meta: LaravelPagination
}


export interface  PaginationLink {
    url: string; 
    label: string; 
    active: boolean
}

export interface LaravelPagination {
    current_page: number;
    from: number;
    last_page: number;
    links?: PaginationLink[];
    path: string;
    per_page: number;
    to: number,
    total?: number
}