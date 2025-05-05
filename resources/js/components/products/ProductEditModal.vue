<script setup lang="ts">
import { Product } from '@/types/product';

const props = defineProps<{
    product: Product | null;
    form: {
        title: string;
        description: string;
        image: string;
        price: number;
    };
    onCancel: () => void;
    onSave: () => void;
}>();
</script>

<template>
    <div
        v-if="product"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50"
    >
        <div class="w-full max-w-md rounded bg-white p-6 shadow-lg">
            <h3 class="mb-4 text-lg font-bold">Edit Product</h3>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium">Title</label>
                    <input
                        v-model="form.title"
                        class="w-full rounded border px-2 py-1"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium">Description</label>
                    <textarea
                        v-model="form.description"
                        class="w-full rounded border px-2 py-1"
                    ></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium">Image URL</label>
                    <input
                        v-model="form.image"
                        class="w-full rounded border px-2 py-1"
                    />
                </div>
                <div>
                    <label class="block text-sm font-medium">Price</label>
                    <input
                        v-model.number="form.price"
                        type="number"
                        class="w-full rounded border px-2 py-1"
                    />
                </div>
            </div>

            <div class="mt-4 flex justify-end gap-2">
                <button @click="onCancel" class="rounded bg-gray-300 px-4 py-2">
                    Cancel
                </button>
                <button
                    @click="onSave"
                    class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700"
                >
                    Save
                </button>
            </div>
        </div>
    </div>
</template>
