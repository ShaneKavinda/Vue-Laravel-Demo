<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';


const customer = ref({
  name: '',
  address: '',
  contact: ''
});

const router = useRouter();


const backToCustomers =  () => {
    router.push('/customers')
}
const createCustomer = () => {
    // Extract the values from the fields
    const { name, address, contact } = customer.value;

    // Prepare data for the POST request
    const updatedCustomer = {   
        name,
        address,
        contact
    }

    // JSON stringify the payload
    const jsonData = JSON.stringify(updatedCustomer);

    // Send the PUT request to the API Endpoint
    axios.post(`http://localhost:8000/api/customers`, jsonData, {
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        console.log('Customer created successfully', response.data);
        // Redirect the user to the ProductsView.vue
        router.push('/customers');
    })
    .catch(error => {
        console.error('Error creating the customer: ', error);
    });
}
</script>


<template>
<form @submit.prevent="createCustomer">
    <div class="space-y-12">
    <div class="border-b border-gray-900/10 pb-12">
        <h2 class="text-base font-semibold leading-7 text-gray-900">Customer</h2>
        <p class="mt-1 text-sm leading-6 text-gray-600">Enter details for the Customer</p>

        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
        <div class="sm:col-span-4">
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Customer Name</label>
            <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <input type="text" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="customer.name"/>
            </div>
            </div>
        </div>

        <div class="sm:col-span-4">
            <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Address</label>
            <div class="mt-2">
            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                <textarea type="text" name="address" id="address" autocomplete="price" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="customer.address" ></textarea>
            </div>
            </div>
        </div>

        <div class="sm:col-span-4">
            <label for="expiry_date" class="block text-sm font-medium leading-6 text-gray-900">Contact Date</label>
            <div class="mt-2">
                <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                    <input type="number" name="expiry_date" id="expiry_date" autocomplete="expiry_date" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="customer.contact"/>
                </div>
            </div>
        </div>
        </div>
    </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
    <button type="button" @click="backToCustomers" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
</form>
</template>
