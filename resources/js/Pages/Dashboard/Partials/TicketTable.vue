<script setup lang="ts">
import { Link } from "@inertiajs/vue3";
import { Ticket } from "../Types/types";
import { Table, Row, Column } from "@/Components/Table";

defineProps<{
    tickets: Ticket[];
}>();

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
    <Table :headers="headers">
        <template #header>
            <div class="mb-6">
                <h3 class="text-lg font-medium">Tiket Terkini</h3>
            </div>
        </template>
        <template #body>
            <Row v-for="(item, key) in tickets" :key="key">
                <Column>{{ key + 1 }}</Column>
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
    </Table>
</template>
