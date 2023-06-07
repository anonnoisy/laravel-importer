<script setup lang="ts">
defineProps<{
    label?: string;
}>();
</script>
<template>
    <div class="flex flex-col">
        <dt v-if="label" class="mb-1 text-sm text-gray-500 dark:text-gray-400">
            {{ label }}
        </dt>
        <dd class="font-semibold">
            <slot></slot>
        </dd>
    </div>
</template>
