<script setup lang="ts">
import { watch, Ref, ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import UploadExcelForm from "@/Components/Form/UploadExcelForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { LinkPagination, PaginationResponse } from "@/types";
import debounce from "lodash.debounce";
import {
    Table,
    Row,
    Column,
    SearchInput,
    Pagination,
} from "@/Components/Table";
import InputLabel from "@/Components/InputLabel.vue";
import Card from "@/Components/Card.vue";
import VueTailwindDatePicker from "vue-tailwind-datepicker";

type Data = {
    code: string;
    customer_id: number;
    product_id: string;
    subject: string;
    issue: string;
    ticket_date: string;
};

const props = defineProps<{
    search: string;
    daterange: string[];
    tickets: PaginationResponse<Data>;
}>();

const tickets: Ref<Data[]> = ref(props.tickets.data);
const links: Ref<LinkPagination[]> = ref(props.tickets.links);
const search: Ref<string> = ref(props.search);
const daterange: Ref<string[]> = ref(props.daterange);

watch(props, () => {
    tickets.value = props.tickets.data;
    links.value = props.tickets.links;
});

const updateTableOnSearch = debounce(() => {
    router.get(
        "/tickets",
        { search: search.value, daterange: daterange.value },
        {
            preserveState: true,
        }
    );
}, 300);

watch([search, daterange], () => {
    updateTableOnSearch();
});

const headers: string[] = [
    "No",
    "Kode Tiket",
    "Customer",
    "Barang",
    "Judul",
    "Keluhan",
    "Tanggal Pengajuan",
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tiket
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <Card>
                    <Table :headers="headers">
                        <template #header>
                            <div class="flex gap-6 mb-6">
                                <div class="w-1/2">
                                    <InputLabel
                                        value="Pencarian"
                                        class="mb-2"
                                    />
                                    <SearchInput
                                        v-model="search"
                                        placeholder="Cari item berdasarkan kode tiket, customer, ..."
                                    />
                                </div>
                                <div class="w-1/2">
                                    <InputLabel
                                        value="Tanggal Tiket"
                                        class="mb-2"
                                    />
                                    <VueTailwindDatePicker
                                        i18n="id"
                                        :formatter="{
                                            date: 'YYYY-MM-DD',
                                            month: 'MMM',
                                        }"
                                        v-model="daterange"
                                    />
                                </div>
                            </div>
                        </template>
                        <template #body>
                            <Row v-for="(item, key) in tickets" :key="key">
                                <Column>{{ props.tickets.from + key }}</Column>
                                <Column>
                                    <Link
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                        :href="
                                            route('tickets.show', {
                                                code: item.code,
                                            })
                                        "
                                    >
                                        {{ item.code }}
                                    </Link>
                                </Column>
                                <Column>{{ item.customer_id }}</Column>
                                <Column>{{ item.product_id }}</Column>
                                <Column>{{ item.subject }}</Column>
                                <Column>{{ item.issue }}</Column>
                                <Column>{{ item.ticket_date }}</Column>
                            </Row>
                        </template>
                        <template #pagination>
                            <Pagination
                                :links="links"
                                :from="props.tickets.from"
                                :to="props.tickets.to"
                                :total="props.tickets.total"
                            />
                        </template>
                    </Table>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
