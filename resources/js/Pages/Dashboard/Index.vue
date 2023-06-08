<script setup lang="ts">
import { Ref, ref, watch } from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import UploadExcelForm from "@/Components/Form/UploadExcelForm.vue";
import Card from "@/Components/Card.vue";
import { Head, router } from "@inertiajs/vue3";
import {
    Sale,
    Ticket,
    Statistic as StatisticType,
    SalesChart as SalesChartType,
    Series,
} from "./Types/types";
import SalesTable from "./Partials/SalesTable.vue";
import Statistic from "./Partials/Statistic.vue";
import TicketTable from "./Partials/TicketTable.vue";
import SalesChart from "./Partials/Charts/SalesChart.vue";
import VueTailwindDatePicker from "vue-tailwind-datepicker";
import debounce from "lodash.debounce";

const props = defineProps<{
    filter: string;
    tickets: Ticket[];
    sales: Sale[];
    statistic: StatisticType;
    revenues: SalesChartType[];
}>();

const seriesMapper = () => {
    return props.revenues.map((item) => {
        return {
            name: item.label,
            data: item.series.map((val) => {
                return {
                    x: val.month,
                    y: val.total_purchase_price,
                };
            }),
        };
    });
};

const filter: Ref<string> = ref(props.filter);
const series: Ref<Series[]> = ref(seriesMapper());

watch(props, () => {
    filter.value = props.filter;
    series.value = seriesMapper();
});

const updateTableOnSearch = debounce(() => {
    router.get(
        "/dashboard",
        {
            filter: filter.value,
        },
        {
            preserveState: true,
        }
    );
}, 300);

watch([filter], () => {
    updateTableOnSearch();
});
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
                    <div class="flex items-center justify-between px-6 py-6">
                        <h4 class="font-semibold">Penadapatan</h4>
                        <div class="w-1/3">
                            <VueTailwindDatePicker
                                i18n="id"
                                as-single
                                v-model="filter"
                                :shortcuts="false"
                                :formatter="{
                                    date: 'YYYY',
                                    month: 'MMM',
                                }"
                            />
                        </div>
                    </div>
                    <SalesChart :series="series" :filter="filter" />
                </Card>
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
