<script setup lang="ts">
import AuthenticatedLayout from '@/layouts/AuthenticatedLayout.vue';
import { useCartStore } from '@/stores/cart';
import { Head } from '@inertiajs/vue3';

const cart = useCartStore();

defineProps<{
    mustVerifyEmail?: boolean;
    status?: string;
}>();

function decreaseOrRemove(itemId: number) {
    const item = cart.items.find((i) => i.id === itemId);
    if (!item) return;

    if (item.quantity <= 1) {
        cart.removeFromCart(itemId);
    } else {
        item.quantity--;
    }
}
</script>

<template>
    <Head title="Your Cart" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Your Cart
            </h2>
        </template>

        <div class="py-12">
            <div class="container py-6">
                <div v-if="cart.items.length === 0">Your cart is empty.</div>
                <div v-else class="space-y-4">
                    <div
                        v-for="item in cart.items"
                        :key="item.id"
                        class="flex items-center justify-between border-b pb-2"
                    >
                        <div>
                            <h3 class="font-semibold">{{ item.title }}</h3>
                            <p>${{ item.price }} x {{ item.quantity }}</p>
                            <p class="text-sm text-gray-600">
                                Subtotal: ${{ item.price * item.quantity }}
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            <button
                                @click="decreaseOrRemove(item.id)"
                                class="rounded bg-gray-200 px-2"
                            >
                                -
                            </button>
                            <button
                                @click="item.quantity++"
                                class="rounded bg-gray-200 px-2"
                            >
                                +
                            </button>
                            <button
                                @click="cart.removeFromCart(item.id)"
                                class="ml-2 text-red-500"
                            >
                                Remove
                            </button>
                        </div>
                    </div>

                    <div class="mt-6 text-right">
                        <p class="text-lg font-bold">
                            Total: ${{ cart.totalPrice.toFixed(2) }}
                        </p>
                        <button
                            @click="cart.clearCart()"
                            class="mt-2 rounded bg-red-500 px-4 py-2 text-white"
                        >
                            Clear Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
