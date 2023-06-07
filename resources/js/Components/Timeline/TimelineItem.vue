<script setup lang="ts"></script>
<template>
    <li class="flex-start group relative flex lg:flex-col">
        <!-- <span
            class="absolute left-[18px] w-px bg-gray-300 lg:right-0 lg:left-auto lg:w-[calc(100%_-_72px)]"
            aria-hidden="true"
        ></span> -->
        <div
            class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-xl border border-gray-300 bg-gray-50 transition-all duration-200 group-hover:border-gray-900 group-hover:bg-gray-900"
        >
            <slot name="icon"></slot>
        </div>
        <div class="ml-6 lg:ml-0 lg:mt-3">
            <p
                class="text-sm font-bold text-gray-900 before:mb-2 before:block before:font-mono before:text-sm before:text-gray-500"
            >
                <slot name="title"></slot>
            </p>
            <h4 class="mt-2 text-base text-gray-700">
                <slot name="text"></slot>
            </h4>
        </div>
    </li>
</template>
