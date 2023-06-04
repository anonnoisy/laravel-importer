<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UploadExcelForm from "@/Components/Form/UploadExcelForm.vue";
import { Head } from "@inertiajs/vue3";
import { PaginationResponse } from "@/types";
import Table from "@/Components/Table/Table.vue";
import TColumn from "@/Components/Table/TColumn.vue";
import TRow from "@/Components/Table/TRow.vue";
import Pagination from "@/Components/Table/Pagination.vue";

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
    sales: PaginationResponse<Data>;
}>();

const sales = props.sales.data;
const links = props.sales.links;

const headers: string[] = [
    "No. Invoice",
    "Customer",
    "Berat",
    "Ongkos Kirim",
    "Total Pembelian",
    "Total Harga",
    "Jenis Pengiriman",
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Beranda
                </h2>

                <UploadExcelForm :url="route('import')" />
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Table :headers="headers">
                    <template #body>
                        <TRow v-for="(item, key) in sales" :key="key">
                            <TColumn>{{ item.invoice_number }}</TColumn>
                            <TColumn>{{ item.customer_id }}</TColumn>
                            <TColumn>{{ item.weight_total }}</TColumn>
                            <TColumn>{{ item.shipping_cost }}</TColumn>
                            <TColumn>{{ item.total_purchase_price }}</TColumn>
                            <TColumn>{{ item.total_price }}</TColumn>
                            <TColumn>{{ item.shipping_type }}</TColumn>
                        </TRow>
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
            </div>
        </div>
    </AuthenticatedLayout>
</template>
