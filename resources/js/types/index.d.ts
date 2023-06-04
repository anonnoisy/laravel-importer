export interface User {
    id: number;
    name: string;
    email: string;
    email_verified_at: string;
}

export type PageProps<
    T extends Record<string, unknown> = Record<string, unknown>
> = T & {
    auth: {
        user: User;
    };
};

export type TColumn = {
    value: string;
    link?: string;
};

export type LinkPagination = {
    url: string;
    label: string;
    active: boolean;
};

export type PaginationResponse<T> = {
    data: T[];
    links: LinkPagination[];
    path: string;
    first_page_url: string;
    last_page_url: string;
    next_page_url: string;
    prev_page_url: string;
    current_page: number;
    last_page: number;
    per_page: number;
    from: number;
    to: number;
    total: number;
};
