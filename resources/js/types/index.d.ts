export interface User {
    id: number;
    name: string;
    firstname?: string;
    firstname?: string;
    full_name?: string;
    avatar?: string;
    email: string;
    email_verified_at: string;
    created_at?: string;
    updated_at?: string;
    deleted_at?: string;
    results?: Result[];
    instructCourses?: Course[];
    enrolledCourses?: Course[];
}

export interface Topic {
    id: number;
    title: string;
    description: string;
    created_at?: string;
    updated_at?: string;
    courses?: Course[];
    exams?: any;
}
export interface ExamSession {
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
export interface Question {
    id: number;
    qtype: string;
    question?: string;
    options?: string;
    answers?: string;
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
    exams?: any;
}

export interface Exam {
    id: number;
    title: string;
    description?: string;
    status?: string;
    duration?: number;
    pass_mark?: number;
    meta?: string;
    number_of_questions?: number;
    random_questions?: string;
    certification?: string;
    difficulty?: string;
    permalink?: string;
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
    slug: string;
    description?: string;
    requirements?: string;
    status?: string;
    thumbnail?: string;
    start_date?: string;
    features?: string;
    rating?: number;
    certified?: string;
    created_at?: string;
    updated_at?: string;
    price: number;
    permalink: string;
    teachers?: User[];
    students?: User[];
    examSessions?: ExamSession[];
    lessons?: Lesson[];
    exams?: Exam[];
    topics?: Topic[];
    subjects?: Subject[];
    lessons_count?: number;
    students_count?: number;
    exam_sessions_count?: number;
    exams_count?: number;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
