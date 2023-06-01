<script setup lang="ts">
defineProps<{
    value?: string;
}>();
</script>

<template>
    <p class="mt-1 text-sm text-gray-700" id="file_input_help">
        <span v-if="value">{{ value }}</span> <span v-else><slot /></span>
    </p>
</template>
