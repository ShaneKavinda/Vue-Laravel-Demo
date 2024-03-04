<template>
    <div>
        <button type="button" @click="createProduct" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Add New Product</button>
        <ProductsTable :products="products" @productDeleted="refreshProducts"/>
    </div>
</template>

<script setup>
    import { ref } from 'vue';
    import ProductsTable from './ProductsTable.vue';
    import { useRouter } from 'vue-router';
    import axios from 'axios';

    const router = useRouter();
    const products = ref([]);

    const createProduct = () => {
        router.push('/products/create');
    };

    const fetchProducts = async () => {
        try {
            const response = await axios.get('http://localhost:8000/api/products');
            products.value = response.data.data;
        } catch (error) {
            console.error('Error fetching products', error);
        }
    };

    const refreshProducts = (deletedProductId) => {
        // Remove the deleted product from the products array
        products.value = products.value.filter(product => product.id !== deletedProductId);
    };

    fetchProducts();
</script>
