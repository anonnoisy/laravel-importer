<script setup lang="ts">
import { ApexOptions } from "apexcharts";
import VueApexCharts from "vue3-apexcharts";
import { Series } from "./../../Types/types";
import { currencyFormat } from "@/Helpers/Formatter";

defineProps<{
    series: Series[];
}>();

const options: ApexOptions = {
    chart: {
        id: "sales-line-series",
    },
    tooltip: {
        y: {
            formatter: function (value) {
                return currencyFormat(value);
            },
        },
    },
    yaxis: {
        labels: {
            formatter: function (value) {
                return new Intl.NumberFormat("id-ID", {
                    style: "currency",
                    currency: "IDR",
                    notation: "compact",
                    compactDisplay: "short",
                }).format(value);
            },
        },
    },
    stroke: {
        curve: "smooth",
    },
};
</script>
<template>
    <VueApexCharts :options="options" :series="series" />
</template>
