<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { LinkPagination, TColumn as TColType } from "@/types";
import Head from "./Head.vue";
import Column from "./Column.vue";
import Row from "./Row.vue";
import Pagination from "./Pagination.vue";

defineProps<{
    headers?: string[];
    rows?: TColType[][];
    links?: LinkPagination[];
}>();
</script>
<template>
    <div class="p-6">
        <slot name="header"></slot>
        <table class="w-full text-sm text-left text-gray-500">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                <tr v-if="headers && headers.length > 0">
                    <Head v-for="(header, key) in headers" :key="key">
                        {{ header }}
                    </Head>
                </tr>
                <slot v-else name="head"></slot>
            </thead>
            <tbody>
                <Row
                    v-if="rows && rows.length > 0"
                    class="border-b hover:bg-gray-50"
                    v-for="(row, rkey) in rows"
                    :key="rkey"
                >
                    <Column v-for="(column, key) in row" :key="key">
                        <Link
                            v-if="column.link"
                            :href="column.link"
                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                        >
                            {{ column.value }}
                        </Link>
                        <span v-else>{{ column.value }}</span>
                    </Column>
                </Row>
                <slot v-else name="body"></slot>
            </tbody>
        </table>
        <Pagination v-if="links && links.length > 0" :links="links" />
        <slot v-else name="pagination"></slot>
    </div>
</template>
