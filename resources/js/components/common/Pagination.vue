<script setup lang="ts">
defineProps<{
    currentPage: number;
    lastPage: number;
    onPageChange: (page: number) => void;
}>();
</script>

<template>
    <div v-if="lastPage > 1" class="mt-6 flex justify-center gap-2">
        <button
            class="rounded bg-gray-200 px-3 py-1"
            :disabled="currentPage === 1"
            @click="onPageChange(currentPage - 1)"
        >
            Previous
        </button>

        <span class="px-2">Page {{ currentPage }} of {{ lastPage }}</span>

        <button
            class="rounded bg-gray-200 px-3 py-1"
            :disabled="currentPage === lastPage"
            @click="onPageChange(currentPage + 1)"
        >
            Next
        </button>
    </div>
</template>
