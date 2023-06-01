<script setup lang="ts">
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputHelp from "@/Components/InputHelp.vue";
import Modal from "@/Components/Modal.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import FileInput from "@/Components/FileInput.vue";
import { useForm } from "@inertiajs/vue3";
import { nextTick, ref } from "vue";

const props = defineProps<{
    url: string;
    title?: string;
    btnLabel?: string;
}>();

const confirmingDataUpload = ref(false);
const fileInput = ref<HTMLInputElement | null>(null);

const form = useForm({
    file: [],
});

const confirmDataUpload = () => {
    confirmingDataUpload.value = true;

    nextTick(() => fileInput.value?.focus());
};

const uploadData = () => {
    form.post(props.url, {
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onError: () => fileInput.value?.focus(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDataUpload.value = false;

    form.reset();
};
</script>

<template>
    <PrimaryButton @click="confirmDataUpload">{{
        props.btnLabel ?? "Unggah Data"
    }}</PrimaryButton>

    <Modal :show="confirmingDataUpload" @close="closeModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900">
                {{ props.title ?? "Pengunggahan Data" }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                Pastikan data yang Anda unggah belum pernah diunggah sebelumnya
                untuk meminimalisir terjadinya duplikasi data dan meminimalisir
                sumber daya terbuang.
            </p>

            <div class="mt-6">
                <InputLabel
                    for="upload-file"
                    value="Kata Sandi"
                    class="sr-only"
                />

                <FileInput
                    id="upload-file"
                    ref="fileInput"
                    v-model="form.file"
                    class="mt-1 block w-full"
                />

                <InputHelp value="File harus XLSX" />

                <InputError :message="form.errors.file" class="mt-2" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeModal"> Batal </SecondaryButton>

                <PrimaryButton
                    class="ml-3"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                    @click="uploadData"
                >
                    {{ props.btnLabel ?? "Unggah Data" }}
                </PrimaryButton>
            </div>
        </div>
    </Modal>
</template>
