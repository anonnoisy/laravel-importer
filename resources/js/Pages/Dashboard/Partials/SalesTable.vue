<script setup lang="ts">
import { Column, Row, Table } from "@/Components/Table";
import { currencyFormat } from "@/Helpers/Formatter";
import { Link } from "@inertiajs/vue3";

type Sale = {
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

defineProps<{
    sales: Sale[];
}>();
</script>
<template>
    <Table>
        <template #header>
            <div class="mb-6">
                <h3 class="text-lg font-medium">Penjualan Terkini</h3>
            </div>
        </template>
        <template #head>
            <Row>
                <Column class="text-center"> NO </Column>
                <Column> No. Invoice </Column>
                <Column> Customer </Column>
                <Column> Total Pembelian </Column>
                <Column> Total Harga </Column>
                <Column class="text-center"> Jenis Pengiriman </Column>
                <Column> Tgl Pengiriman </Column>
                <Column> Tgl Transaksi </Column>
            </Row>
        </template>
        <template #body>
            <Row v-for="(item, key) in sales" :key="key">
                <Column class="text-center">
                    {{ key + 1 }}
                </Column>
                <Column>
                    <Link
                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                        :href="
                            route('sales.show', {
                                invoice_number: item.invoice_number,
                            })
                        "
                    >
                        {{ item.invoice_number }}
                    </Link>
                </Column>
                <Column>{{ item.customer_id }}</Column>
                <Column>
                    {{ currencyFormat(item.total_purchase_price) }}
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
    </Table>
</template>
