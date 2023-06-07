<script setup lang="ts">
import { onMounted } from "vue";

const props = withDefaults(
    defineProps<{
        color?: string;
        label?: string;
        value?: string;
    }>(),
    {
        color: "teal",
    }
);
</script>
<template>
    <div class="p-4 flex items-center">
        <div
            :class="[
                'p-3',
                'rounded-full',
                `text-${color}-500`,
                `dark:text-${color}-100`,
                `bg-${color}-100`,
                `dark:bg-${color}-500`,
                'mr-4',
            ]"
        >
            <slot></slot>
        </div>
        <div>
            <p
                class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
                <slot
                    v-if="label === undefined || label === null"
                    name="label"
                ></slot>
                <span v-else>{{ label }}</span>
            </p>
            <p class="text-lg font-semibold text-gray-700 dark:text-gray-200">
                <slot
                    v-if="value === undefined || value === null"
                    name="value"
                ></slot>
                <span v-else>{{ value }}</span>
            </p>
        </div>
    </div>
</template>
