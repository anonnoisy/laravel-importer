<script setup lang="ts">
import Card from "@/Components/Card.vue";
import { List, ListGroup, ListItem } from "@/Components/List";
import { Table, Row, Column } from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { Ref } from "vue";
import { currencyFormat, discountFormat } from "@/Helpers/Formatter";

type Sale = {
    id: number;
    invoice_number: string;
    customer_id: number;
    weight_total: string;
    shipping_cost: string;
    total_price: string;
    total_purchase_price: string;
    shipping_date: string;
    shipping_address: string;
    shipping_type: string;
    shipping_service_id: number;
    transaction_date: string;
};

type Product = {
    id: number;
    sale_id: number;
    name: number;
    category: number;
    qty: string;
    weight: string;
    price: string;
    discount: string;
    total: string;
};

const props = defineProps<{
    sale: Sale;
    products: Product[];
}>();

const sale: Ref<Sale> = ref(props.sale);
const products: Ref<Product[]> = ref(props.products);

const calculateSum = <T>(array: T[], property: any) => {
    const total = array.reduce((accumulator, object) => {
        const value = object[property as keyof object];
        const parsed =
            typeof value === "string" ? Number.parseFloat(value) : value;
        return accumulator + parsed;
    }, 0);

    return total;
};
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Penjualan - {{ sale.invoice_number }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
                <Card class="bg-white rounded-lg px-6 py-3">
                    <h3 class="font-semibold mb-2 mt-2">Rincian Transaksi</h3>
                    <ListGroup>
                        <List>
                            <ListItem class="w-1/6" label="No. Invoice">
                                {{ sale.invoice_number }}
                            </ListItem>
                            <ListItem label="Tanggal Transaksi">
                                {{ sale.transaction_date }}
                            </ListItem>
                        </List>
                        <List>
                            <ListItem class="w-1/6" label="Customer">
                                {{ sale.customer_id }}
                            </ListItem>
                            <ListItem label="Alamat Tujuan">
                                {{ sale.shipping_address }}
                            </ListItem>
                        </List>
                        <List>
                            <ListItem class="w-1/6" label="Tanggal Pengiriman">
                                {{ sale.shipping_date }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Layanan">
                                {{ sale.shipping_service_id }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Jenis Layanan">
                                {{ sale.shipping_type }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Berat Barang">
                                {{ sale.weight_total }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Biaya">
                                {{ currencyFormat(sale.shipping_cost) }}
                            </ListItem>
                        </List>
                        <List>
                            <ListItem class="w-1/6" label="Banyaknya Barang">
                                {{ calculateSum(products, "qty") }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Total Pembelian">
                                {{ currencyFormat(sale.total_purchase_price) }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Total Harga">
                                {{ currencyFormat(sale.total_price) }}
                            </ListItem>
                        </List>
                    </ListGroup>
                </Card>
                <Card>
                    <Table>
                        <template #header>
                            <h4 class="mb-3 font-semibold">Daftar Barang</h4>
                        </template>
                        <template #head>
                            <Row>
                                <Column>Nama</Column>
                                <Column class="text-center"> Kategori </Column>
                                <Column class="text-center"> Berat </Column>
                                <Column class="text-center"> Jumlah </Column>
                                <Column> Harga </Column>
                                <Column class="text-center"> Diskon </Column>
                                <Column class="text-right"> Total </Column>
                            </Row>
                        </template>
                        <template #body>
                            <Row v-for="(item, key) in products" :key="key">
                                <Column>{{ item.name }}</Column>
                                <Column class="text-center">
                                    {{ item.category }}
                                </Column>
                                <Column class="text-center">
                                    {{ item.weight }}
                                </Column>
                                <Column class="text-center">
                                    {{ item.qty }}
                                </Column>
                                <Column>
                                    {{ currencyFormat(item.price) }}
                                </Column>
                                <Column class="text-center">
                                    {{ discountFormat(item.discount) }}
                                </Column>
                                <Column class="text-right">
                                    {{ currencyFormat(item.total) }}
                                </Column>
                            </Row>
                            <Row class="uppercase font-black">
                                <Column class="text-right" colspan="6">
                                    Total Harga
                                </Column>
                                <Column class="text-right">
                                    {{
                                        currencyFormat(
                                            calculateSum(products, "total")
                                        )
                                    }}
                                </Column>
                            </Row>
                        </template>
                    </Table>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
