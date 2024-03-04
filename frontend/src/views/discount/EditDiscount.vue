<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const discountId = ref(null);
const discount = ref({
  product_id: '',
  discount: '',
  lower_limit: '',
  upper_limit: ''
});

const products = ref([])

axios.get(`http://localhost:8000/api/products`)
.then(response=>{
    products.value = response.data.data
    console.log('products: ', products.value)
}).catch(error => {
    console.error('Error fetching products: ', error)
})

const router = useRouter();

onMounted(() => {
     fetchDiscount();
     console.log(discount.value)
});

const fetchDiscount = () => {
    //console.log(router.currentRoute.value.params.id)
    discountId.value = router.currentRoute.value.params.id;
    axios.get(`http://localhost:8000/api/discounts/${discountId.value}`)
    .then(response => {
       discount.value = response.data;
       console.log('discount: ',discount.value)
    })
    .catch(error => {
      console.error('Error fetching discount: ', error);
    });
};

const backToDiscounts =  () => {
    router.push('/discounts')
}
const updateDiscount = () => {
    const updatedDiscount = {
            product_id: discount.value.product_id,
            discount: discount.value.discount,
            lower_limit: discount.value.lower_limit,
            upper_limit: discount.value.upper_limit
    };

    // JSON stringify the payload
    const jsonData = JSON.stringify(updatedDiscount);

    // Send the PUT request to the API Endpoint
    axios.put(`http://localhost:8000/api/discounts/${discountId.value}`, jsonData, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Discount updated successfully', response.data);
        // Redirect the user to the ProductsView.vue
        router.push('/discounts');
    })
    .catch(error => {
        console.error('Error updating the discount: ', error);
    });
}
</script>


<template>
<form @submit.prevent="updateDiscount">
    <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Edit Discount</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Enter details for the Discount</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
            <div class="sm:col-span-4">
            <label for="product_id" class="block text-sm font-medium leading-6 text-gray-900">Product</label>
            <div class="mt-2">
                <select class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md" v-model="discount.product_id" >
                <option v-for="product in products" :value="product.id" :key="product.id">{{ product.name }}</option>
                </select>
            </div>
        </div>

        <div class="sm:col-span-4">
            <label for="discount" class="block text-sm font-medium leading-6 text-gray-900">Discount</label>
            <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <textarea type="text" name="discount" id="discount" autocomplete="discount" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="discount.discount"></textarea>
            </div>
            </div>
        </div>

        <div class="sm:col-span-4">
            <label for="lower_limit" class="block text-sm font-medium leading-6 text-gray-900">Lower Limit</label>
            <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input type="number" name="lower_limit" id="lower_limit" autocomplete="lower_limit" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="discount.lower_limit"/>
                </div>
            </div>
        </div>
        <div class="sm:col-span-4">
            <label for="upper_limit" class="block text-sm font-medium leading-6 text-gray-900">Upper Limit</label>
            <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input type="number" name="upper_limit" id="upper_limit" autocomplete="upper_limit" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="discount.upper_limit"/>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
    <button type="button" @click="backToDiscounts" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <button type="submit" @click="updateDiscount" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
</form>
</template>
