export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export interface Subject {
    id: number,
    title: string,
    description: string
    courses?: Course[]
}

export interface Course {
    id: number,
    title: string,
    price: number
    permalink: string
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
