<script setup lang="ts">
import UploadExcelForm from "@/Components/Form/UploadExcelForm.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, router } from "@inertiajs/vue3";
import { LinkPagination, PaginationResponse } from "@/types";
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
import InputLabel from "@/Components/InputLabel.vue";
import Card from "@/Components/Card.vue";
import { currencyFormat } from "@/Helpers/Formatter";

type Data = {
    id: number;
    name: string;
    weight: string;
    stock: string;
    purchase_price: number;
    sell_price: string;
};

const props = defineProps<{
    search: string;
    products: PaginationResponse<Data>;
}>();

const products: Ref<Data[]> = ref(props.products.data);
const links: Ref<LinkPagination[]> = ref(props.products.links);
const search: Ref<string> = ref(props.search);

watch(props, () => {
    products.value = props.products.data;
    links.value = props.products.links;
});

const updateTableOnSearch = debounce(() => {
    router.get(
        "/products",
        { search: search.value },
        {
            preserveState: true,
        }
    );
}, 300);

watch(search, () => {
    updateTableOnSearch();
});

const headers: string[] = [
    "No",
    "Nama Barang",
    "Berat",
    "Stok",
    "Harga Beli",
    "Harga Jual",
];
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Barang
                </h2>
            </div>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6">
                <Card>
                    <Table>
                        <template #header>
                            <div class="mb-6">
                                <InputLabel value="Pencarian" class="mb-2" />
                                <SearchInput
                                    v-model="search"
                                    placeholder="Cari barang berdasarkan nama"
                                />
                            </div>
                        </template>
                        <template #head>
                            <Column class="text-center">No</Column>
                            <Column>Nama Barang</Column>
                            <Column>Berat</Column>
                            <Column>Stok</Column>
                            <Column>Harga Beli</Column>
                            <Column>Harga Jual</Column>
                        </template>
                        <template #body>
                            <Row v-for="(item, key) in products" :key="key">
                                <Column class="text-center">
                                    {{ props.products.from + key }}
                                </Column>
                                <Column>{{ item.name }}</Column>
                                <Column>{{ item.weight }}</Column>
                                <Column>{{ item.stock }}</Column>
                                <Column>
                                    {{ currencyFormat(item.purchase_price) }}
                                </Column>
                                <Column>
                                    {{ currencyFormat(item.sell_price) }}
                                </Column>
                            </Row>
                        </template>
                        <template #pagination>
                            <Pagination
                                :links="links"
                                :from="props.products.from"
                                :to="props.products.to"
                                :total="props.products.total"
                            />
                        </template>
                    </Table>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
