import ProductList from '@/pages/Products/ProductList.vue';
import { fetchProducts } from '@/services/productService';
import { useCartStore } from '@/stores/cart';
import { flushPromises, mount } from '@vue/test-utils';
import { createPinia, setActivePinia } from 'pinia';
import { beforeEach, describe, expect, it, vi } from 'vitest';

vi.mock('@/services/productService', () => ({
    fetchProducts: vi.fn(),
    updateProduct: vi.fn(),
}));

describe('ProductList.vue', () => {
    beforeEach(() => {
        setActivePinia(createPinia());
    });

    it('fetches and displays products', async () => {
        (fetchProducts as any).mockResolvedValueOnce({
            data: [
                {
                    id: 1,
                    title: 'Test Product',
                    price: 99.99,
                    category: 'test-category',
                    image: 'https://example.com/image.jpg',
                },
            ],
            current_page: 1,
            last_page: 1,
        });

        const wrapper = mount(ProductList);
        await flushPromises();

        expect(wrapper.text()).toContain('Test Product');
        expect(wrapper.find('button').text()).toContain('Add to Cart');
    });

    it('adds product to cart on button click', async () => {
        (fetchProducts as any).mockResolvedValueOnce({
            data: [
                {
                    id: 1,
                    title: 'Cart Product',
                    price: 10,
                    category: 'cart',
                    image: '',
                },
            ],
            current_page: 1,
            last_page: 1,
        });

        const wrapper = mount(ProductList);
        await flushPromises();

        const cart = useCartStore();
        expect(cart.items.length).toBe(0);

        const addToCartButton = wrapper
            .findAll('button')
            .find((b) => b.text().includes('Add to Cart'))!;
        await addToCartButton.trigger('click');

        expect(cart.items.length).toBe(1);
        expect(cart.items[0].title).toBe('Cart Product');
    });
});
