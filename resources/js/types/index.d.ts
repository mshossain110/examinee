
export * from './resources';
export * from './forms';
export * from './icons';

export type Strategy = 'merge' | 'override'

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
    auth: {
        user: User;
    };
};
