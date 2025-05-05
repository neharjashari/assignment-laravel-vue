<script setup lang="ts">
import { useCartStore } from '@/stores/cart';
import { Product } from '@/types/product';

defineProps<{
    product: Product;
    onEdit: (product: Product) => void;
}>();

const cart = useCartStore();
</script>

<template>
    <div class="rounded-lg border p-4 shadow-sm">
        <img
            :src="product.image"
            :alt="product.title"
            class="h-40 w-full object-contain"
        />
        <h3 class="mt-2 text-lg font-semibold">{{ product.title }}</h3>
        <p class="text-sm text-gray-600">{{ product.category }}</p>
        <p class="mt-1 font-bold">${{ product.price }}</p>
        <div class="mt-4 flex justify-between">
            <button
                class="rounded bg-blue-500 px-3 py-1 text-white hover:bg-blue-600"
                @click="cart.addToCart({ ...product, quantity: 1 })"
            >
                Add to Cart
            </button>
            <button
                class="rounded bg-green-500 px-3 py-1 text-white hover:bg-green-600"
                @click="onEdit(product)"
            >
                Edit
            </button>
        </div>
    </div>
</template>
