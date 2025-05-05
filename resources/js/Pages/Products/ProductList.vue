<script setup lang="ts">
import Pagination from '@/components/common/Pagination.vue';
import ProductCard from '@/components/products/ProductCard.vue';
import EditProductModal from '@/components/products/ProductEditModal.vue';
import { fetchProducts, updateProduct } from '@/services/productService';
import { Product } from '@/types/product';
import { onMounted, ref } from 'vue';
import { useToast } from 'vue-toastification';

const toast = useToast();
const products = ref<Product[]>([]);
const loading = ref(true);
const currentPage = ref(1);
const lastPage = ref(1);

const editingProduct = ref<Product | null>(null);
const editForm = ref({ title: '', description: '', image: '', price: 0 });

function openEditForm(product: Product) {
    editingProduct.value = { ...product };
    editForm.value = {
        title: product.title,
        description: product.description,
        image: product.image,
        price: product.price,
    };
}

async function saveEdit() {
    if (!editingProduct.value) return;

    try {
        await updateProduct(editingProduct.value.id, editForm.value);
        const index = products.value.findIndex(
            (p) => p.id === editingProduct.value?.id,
        );
        if (index !== -1) {
            products.value[index] = {
                ...products.value[index],
                ...editForm.value,
            };
        }
        editingProduct.value = null;
        toast.success('Product updated!');
    } catch (err) {
        toast.error('Failed to update product.');
    }
}

function cancelEdit() {
    editingProduct.value = null;
}

async function loadProducts(page = 1) {
    loading.value = true;
    try {
        const res = await fetchProducts(page);
        products.value = res.data;
        currentPage.value = res.current_page;
        lastPage.value = res.last_page;
    } finally {
        loading.value = false;
    }
}

onMounted(() => {
    loadProducts();
});
</script>

<template>
    <div class="container py-4">
        <h2 class="mb-4 text-2xl font-bold">Product List</h2>

        <div v-if="loading">
            <p class="text-gray-500">Loading products...</p>
        </div>

        <div v-else class="grid grid-cols-1 gap-4 md:grid-cols-3">
            <ProductCard
                v-for="product in products"
                :key="product.id"
                :product="product"
                :onEdit="openEditForm"
            />
        </div>

        <Pagination
            :currentPage="currentPage"
            :lastPage="lastPage"
            :onPageChange="loadProducts"
        />

        <EditProductModal
            :product="editingProduct"
            :form="editForm"
            :onCancel="cancelEdit"
            :onSave="saveEdit"
        />
    </div>
</template>
