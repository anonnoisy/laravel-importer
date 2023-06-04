<script setup lang="ts">
defineProps<{
    title: string;
    message: string;
}>();
</script>
<template>
    <div class="flex">
        <div>
            <p class="font-bold">{{ title }}</p>
            <p class="text-sm">{{ message }}</p>
        </div>
    </div>
</template>
