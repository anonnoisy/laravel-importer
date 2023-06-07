<script setup lang="ts">
import Card from "@/Components/Card.vue";
import Stats from "@/Components/Stats.vue";
import {
    IconReportAnalytics,
    IconReportMoney,
    IconUsers,
    IconTicket,
} from "@tabler/icons-vue";
import { Statistic as StatisticType } from "./../Types/types";
import { currencyFormat } from "@/Helpers/Formatter";

defineProps<{
    statistic: StatisticType;
}>();
</script>
<template>
    <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-4">
        <Card>
            <Stats
                label="Total Penjualan"
                :value="statistic.total_sales.toString()"
                color="teal"
            >
                <IconReportAnalytics />
            </Stats>
        </Card>
        <Card>
            <Stats
                label="Total Pendapatan"
                :value="currencyFormat(statistic.total_revenue)"
                color="yellow"
            >
                <IconReportMoney />
            </Stats>
        </Card>
        <Card>
            <Stats
                label="Total Customer"
                :value="statistic.total_customer.toString()"
                color="green"
            >
                <IconUsers />
            </Stats>
        </Card>
        <Card>
            <Stats
                label="Total Tiket Masuk"
                :value="statistic.total_ticket.toString()"
                color="pink"
            >
                <IconTicket />
            </Stats>
        </Card>
    </div>
</template>
