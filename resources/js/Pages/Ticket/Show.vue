<script setup lang="ts">
import Card from "@/Components/Card.vue";
import { List, ListGroup, ListItem } from "@/Components/List";
import { Table, Row, Column } from "@/Components/Table";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head } from "@inertiajs/vue3";
import { ref } from "vue";
import { Ref } from "vue";

type Ticket = {
    code: string;
    customer: number;
    product_id: number;
    subject: string;
    issue: string;
    ticket_date: string;
};

type TicketProcess = {
    status: string;
    user: number;
    update_date: string;
};

const props = defineProps<{
    ticket: Ticket;
    ticketProcesses: TicketProcess[];
}>();

const ticket: Ref<Ticket> = ref(props.ticket);
const ticketProcesses: Ref<TicketProcess[]> = ref(props.ticketProcesses);
</script>

<template>
    <Head title="Rincian Tiket" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Tiket - {{ ticket.code }}
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-col gap-4">
                <Card class="bg-white rounded-lg px-6 py-3">
                    <h3 class="font-semibold mb-2 mt-2">Rincian Tiket</h3>
                    <ListGroup>
                        <List>
                            <ListItem class="w-1/6" label="Kode Tiket">
                                {{ ticket.code }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Customer">
                                {{ ticket.customer }}
                            </ListItem>
                        </List>
                        <List>
                            <ListItem class="w-1/6" label="Barang">
                                {{ ticket.product_id }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Judul">
                                {{ ticket.subject }}
                            </ListItem>
                            <ListItem class="w-1/6" label="Keluhan">
                                {{ ticket.issue }}
                            </ListItem>
                        </List>
                    </ListGroup>
                </Card>
                <Card
                    ><Table>
                        <template #header>
                            <h4 class="mb-3 font-semibold">Daftar Proses</h4>
                        </template>
                        <template #head>
                            <Row>
                                <Column>Status</Column>
                                <Column> Diperbarui Oleh </Column>
                                <Column> Diperbarui Pada </Column>
                            </Row>
                        </template>
                        <template #body>
                            <Row
                                v-for="(item, key) in ticketProcesses"
                                :key="key"
                            >
                                <Column>{{ item.status }}</Column>
                                <Column>{{ item.user }}</Column>
                                <Column>{{ item.update_date }}</Column>
                            </Row>
                        </template>
                    </Table>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
