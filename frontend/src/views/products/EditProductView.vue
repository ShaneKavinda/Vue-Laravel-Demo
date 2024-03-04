<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const productId = ref(null);
const product = ref({
  name: '',
  price: '',
  expiry_date: ''
});

const router = useRouter();

onMounted(() => {
     fetchProduct();
});

const fetchProduct = () => {
    productId.value = router.currentRoute.value.params.id;
    axios.get(`http://localhost:8000/api/products/${productId.value}`)
    .then(response => {
       // Convert date format
       const dateParts = response.data.expiry_date.split(' ')[0].split('-');
       const formattedDate = `${dateParts[0]}-${dateParts[1]}-${dateParts[2]}`;

       // Update product data
       product.value = {
           ...response.data,
           expiry_date: formattedDate
       };
    })
    .catch(error => {
      console.error('Error fetching product: ', error);
    });
};

const backToProducts =  () => {
    router.push('/products')
}
const updateProduct = () => {
    // Extract the values from the fields
    const { name, price, expiry_date } = product.value;

    // Prepare data for the PUT request
    const updatedProduct = {
        name,
        price,
        expiry_date
    }

    // JSON stringify the payload
    const jsonData = JSON.stringify(updatedProduct);

    // Send the PUT request to the API Endpoint
    axios.put(`http://localhost:8000/api/products/${productId.value}`, jsonData, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Product updated successfully', response.data);
        // Redirect the user to the ProductsView.vue
        router.push('/products');
    })
    .catch(error => {
        console.error('Error updating the product: ', error);
    });
}
</script>


<template>
<form @submit.prevent="updateProduct">
    <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Product</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Enter details for the product</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Product Name</label>
            <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="product.name"/>
            </div>
            </div>
        </div>

        <div class="sm:col-span-4">
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Price</label>
            <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="price" id="price" autocomplete="price" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="product.price"/>
            </div>
            </div>
        </div>

        <div class="sm:col-span-4">
            <label for="expiry_date" class="block text-sm font-medium leading-6 text-gray-900">Expiry Date</label>
            <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input type="date" name="expiry_date" id="expiry_date" autocomplete="expiry_date" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="product.expiry_date"/>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
    <button type="button" @click="backToProducts" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <button type="submit" @click="updateProduct" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
</form>
</template>
