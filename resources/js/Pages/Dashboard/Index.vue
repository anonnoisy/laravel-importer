<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UploadExcelForm from "@/Components/Form/UploadExcelForm.vue";
import Card from "@/Components/Card.vue";
import { Head } from "@inertiajs/vue3";
import { Sale, Ticket, Statistic as StatisticType } from "./Types/types";
import SalesTable from "./Partials/SalesTable.vue";
import Statistic from "./Partials/Statistic.vue";
import TicketTable from "./Partials/TicketTable.vue";

const props = defineProps<{
    tickets: Ticket[];
    sales: Sale[];
    statistic: StatisticType;
}>();
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
            <div class="max-w-7xl mx-auto sm:px-6 flex flex-col gap-6">
                <Statistic :statistic="statistic" />
                <Card>
                    <SalesTable :sales="sales" />
                </Card>
                <Card>
                    <TicketTable :tickets="tickets" />
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
