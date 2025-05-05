import axios from '@/lib/axios';

const csrf = () => axios.get('/sanctum/csrf-cookie');

export async function fetchProducts(page = 1) {
    await csrf();
    const { data } = await axios.get(`/api/products?page=${page}`);
    return data;
}

export async function updateProduct(
    id: number,
    form: Partial<{
        title: string;
        description: string;
        image: string;
        price: number;
    }>,
) {
    await axios.put(`/api/products/${id}`, form);
}
