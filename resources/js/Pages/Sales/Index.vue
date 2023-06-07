<script setup lang="ts">
import UploadExcelForm from "@/Components/Form/UploadExcelForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { LinkPagination, PaginationResponse } from "@/types";
import { Head, Link, router } from "@inertiajs/vue3";
import { watch } from "vue";
import { ref } from "vue";
import { Ref } from "vue";
import debounce from "lodash.debounce";
import {
    Table,
    Row,
    Column,
    SearchInput,
    Pagination,
} from "@/Components/Table";
import VueTailwindDatePicker from "vue-tailwind-datepicker";
import InputLabel from "@/Components/InputLabel.vue";
import Card from "@/Components/Card.vue";
import { currencyFormat } from "@/Helpers/Formatter";

type Data = {
    id: number;
    invoice_number: string;
    customer_id: number;
    weight_total: string;
    shipping_cost: string;
    total_price: string;
    total_purchase_price: string;
    shipping_date: string;
    shipping_type: number;
    transaction_date: string;
};

const props = defineProps<{
    search: string;
    shippingDate: string[];
    transactionDate: string[];
    sales: PaginationResponse<Data>;
}>();

const sales: Ref<Data[]> = ref(props.sales.data);
const links: Ref<LinkPagination[]> = ref(props.sales.links);
const search: Ref<string> = ref(props.search);
const shippingDate: Ref<string[]> = ref(props.shippingDate);
const transactionDate: Ref<string[]> = ref(props.transactionDate);

watch(props, () => {
    sales.value = props.sales.data;
    links.value = props.sales.links;
});

const updateTableOnSearch = debounce(() => {
    router.get(
        "/sales",
        {
            search: search.value,
            shipping_date: shippingDate.value,
            transaction_date: transactionDate.value,
        },
        {
            preserveState: true,
        }
    );
}, 300);

watch([search, shippingDate, transactionDate], () => {
    updateTableOnSearch();
});

const headers: string[] = [
    "No",
    "No. Invoice",
    "Customer",
    "Total Pembelian",
    "Total Harga",
    "Jenis Pengiriman",
    "Tgl Pengiriman",
    "Tgl Transaksi",
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Penjualan
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <Card>
                    <Table>
                        <template #header>
                            <div class="flex gap-6 mb-6">
                                <div class="w-1/3">
                                    <InputLabel
                                        value="Pencarian"
                                        class="mb-2"
                                    />
                                    <SearchInput
                                        v-model="search"
                                        placeholder="Cari penjualan berdasarkan invoice, customer, jenis pengiriman"
                                    />
                                </div>
                                <div class="w-1/3">
                                    <InputLabel
                                        value="Tanggal Pengiriman"
                                        class="mb-2"
                                    />
                                    <VueTailwindDatePicker
                                        i18n="id"
                                        :formatter="{
                                            date: 'YYYY-MM-DD',
                                            month: 'MMM',
                                        }"
                                        v-model="shippingDate"
                                    />
                                </div>
                                <div class="w-1/3">
                                    <InputLabel
                                        value="Tanggal Transaksi"
                                        class="mb-2"
                                    />
                                    <VueTailwindDatePicker
                                        i18n="id"
                                        :formatter="{
                                            date: 'YYYY-MM-DD',
                                            month: 'MMM',
                                        }"
                                        v-model="transactionDate"
                                    />
                                </div>
                            </div>
                        </template>
                        <template #head>
                            <Row>
                                <Column class="text-center"> NO </Column>
                                <Column> No. Invoice </Column>
                                <Column> Customer </Column>
                                <Column> Total Pembelian </Column>
                                <Column> Total Harga </Column>
                                <Column class="text-center">
                                    Jenis Pengiriman
                                </Column>
                                <Column> Tgl Pengiriman </Column>
                                <Column> Tgl Transaksi </Column>
                            </Row>
                        </template>
                        <template #body>
                            <Row v-for="(item, key) in sales" :key="key">
                                <Column class="text-center">
                                    {{ props.sales.from + key }}
                                </Column>
                                <Column>
                                    <Link
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                        :href="
                                            route('sales.show', {
                                                invoice_number:
                                                    item.invoice_number,
                                            })
                                        "
                                    >
                                        {{ item.invoice_number }}
                                    </Link>
                                </Column>
                                <Column>{{ item.customer_id }}</Column>
                                <Column>
                                    {{
                                        currencyFormat(
                                            item.total_purchase_price
                                        )
                                    }}
                                </Column>
                                <Column>
                                    {{ currencyFormat(item.total_price) }}
                                </Column>
                                <Column class="text-center">
                                    {{ item.shipping_type }}
                                </Column>
                                <Column>{{ item.shipping_date }}</Column>
                                <Column>{{ item.transaction_date }}</Column>
                            </Row>
                        </template>
                        <template #pagination>
                            <Pagination
                                :links="links"
                                :from="props.sales.from"
                                :to="props.sales.to"
                                :total="props.sales.total"
                            />
                        </template>
                    </Table>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
