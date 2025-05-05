import Cart from '@/pages/Products/Cart.vue';
import { useCartStore } from '@/stores/cart';
import { mount } from '@vue/test-utils';
import { createPinia, setActivePinia } from 'pinia';
import { beforeEach, describe, expect, it, vi } from 'vitest';

vi.mock('@/layouts/AuthenticatedLayout.vue', () => ({
    default: {
        name: 'AuthenticatedLayout',
        template: '<div><slot /></div>',
    },
}));

vi.mock('@inertiajs/vue3', async () => {
    const actual = await vi.importActual('@inertiajs/vue3');
    return {
        ...actual,
        Head: {
            name: 'Head',
            template: '<div><slot /></div>',
        },
    };
});

describe('Cart.vue', () => {
    beforeEach(() => {
        setActivePinia(createPinia());

        const cart = useCartStore();
        cart.items = [
            {
                id: 1,
                title: 'Item 1',
                price: 20,
                quantity: 2,
            },
        ];
    });

    it('displays cart items and total', () => {
        const wrapper = mount(Cart);
        expect(wrapper.text()).toContain('Item 1');
        expect(wrapper.text()).toContain('Subtotal: $40');
        expect(wrapper.text()).toContain('Total: $40.00');
    });

    it('removes item when "Remove" is clicked', async () => {
        const wrapper = mount(Cart);
        await wrapper.get('button.text-red-500').trigger('click');

        const cart = useCartStore();
        expect(cart.items.length).toBe(0);
    });

    it('increments and decrements quantity', async () => {
        const wrapper = mount(Cart);
        const cart = useCartStore();

        const incrementBtn = wrapper
            .findAll('button')
            .find((b) => b.text() === '+')!;
        const decrementBtn = wrapper
            .findAll('button')
            .find((b) => b.text() === '-')!;

        await incrementBtn.trigger('click');
        expect(cart.items[0].quantity).toBe(3);

        await decrementBtn.trigger('click');
        expect(cart.items[0].quantity).toBe(2);
    });

    it('clears cart on checkout', async () => {
        const wrapper = mount(Cart);
        await wrapper.find('button.bg-red-500').trigger('click');

        const cart = useCartStore();
        expect(cart.items.length).toBe(0);
    });
});
