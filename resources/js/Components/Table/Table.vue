<script setup lang="ts">
import SearchInput from "@/Components/Table/SearchInput.vue";
import THead from "./THead.vue";
import TColumn from "./TColumn.vue";
import { Link } from "@inertiajs/vue3";
import { LinkPagination, TColumn as TColType } from "@/types";
import Pagination from "./Pagination.vue";

defineProps<{
    headers?: string[];
    rows?: TColType[][];
    links?: LinkPagination[];
}>();
</script>
<template>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:mx-6">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg p-6">
            <SearchInput />
            <table class="w-full text-sm text-left text-gray-500">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr v-if="headers && headers.length > 0">
                        <THead v-for="(header, key) in headers" :key="key">
                            {{ header }}
                        </THead>
                    </tr>
                    <tr v-else>
                        <slot name="head"></slot>
                    </tr>
                </thead>
                <tbody>
                    <TRow
                        v-if="rows && rows.length > 0"
                        class="border-b hover:bg-gray-50"
                        v-for="(row, rkey) in rows"
                        :key="rkey"
                    >
                        <TColumn v-for="(column, key) in row" :key="key">
                            <Link
                                v-if="column.link"
                                :href="column.link"
                                class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                            >
                                {{ column.value }}
                            </Link>
                            <span v-else>{{ column.value }}</span>
                        </TColumn>
                    </TRow>
                    <slot v-else name="body"></slot>
                </tbody>
            </table>
            <Pagination v-if="links && links.length > 0" :links="links" />
            <slot v-else name="pagination"></slot>
        </div>
    </div>
</template>
