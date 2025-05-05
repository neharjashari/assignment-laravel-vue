import { defineStore } from 'pinia';
import { useToast } from 'vue-toastification';

interface CartItem {
    id: number;
    title: string;
    price: number;
    quantity: number;
}

export const useCartStore = defineStore('cart', {
    state: () => ({
        items: [] as CartItem[],
    }),

    getters: {
        totalQuantity: (state) =>
            state.items.reduce((sum, item) => sum + item.quantity, 0),
        totalPrice: (state) =>
            state.items.reduce(
                (sum, item) => sum + item.quantity * item.price,
                0,
            ),
    },

    actions: {
        addToCart(product: CartItem) {
            const existing = this.items.find((p) => p.id === product.id);
            const toast = useToast();
            if (existing) {
                existing.quantity++;
            } else {
                this.items.push({ ...product, quantity: 1 });
            }
            toast.info('Product added to cart');
        },
        removeFromCart(productId: number) {
            this.items = this.items.filter((item) => item.id !== productId);
        },
        clearCart() {
            this.items = [];
        },
    },

    persist: true,
});
