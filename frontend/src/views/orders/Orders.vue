<template>
    <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com --> 
    <div class="flex flex-col">
    <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <button type="button" @click="createOrder" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Add New Order</button>
        <div class="overflow-hidden">
            <table class="min-w-full text-left text-sm font-light">
            <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                <th scope="col" class="px-6 py-4">Order Num</th>
                <th scope="col" class="px-6 py-4">Customer</th>
                <th scope="col" class="px-6 py-4">Net Amount</th>
                <th scope="col" class="px-6 py-4">Order Date</th>
                <th scope="col" class="px-6 py-4">Order Time</th>
                <th scope="col" class="px-6 py-4"> Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item in orders" 
                    class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                    <td class="whitespace-nowrap px-6 py-4 font-medium">{{ item.id }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ item.customer.name }}</td> 
                    <td class="whitespace-nowrap px-6 py-4">{{ item.net_amount }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ item.order_date }}</td>
                    <td class="whitespace-nowrap px-6 py-4">{{ item.order_time }}</td>
                    <td class="flex">
                        <button type="button" @click="viewOrder(item.id)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">View</button>
                    </td>
                </tr>
            </tbody>

            </table>
        </div>
        </div>
    </div>
    </div>
</template>

<script setup>
import axios from "axios";
import { useRouter } from "vue-router";
import { onMounted, ref } from 'vue';

const router = useRouter();
const orders = ref([]);


onMounted(async () => {
    await fetchOrders();
});

const fetchOrders = async () => {
try {
    const response = await axios.get('http://localhost:8000/api/orders');
    orders.value = response.data.orders;
    console.log('orders:', orders.value)
} catch (error) {
    console.error('Error fetching Orders: ', error);
}
};

const viewOrder = (id) => {
    router.push(`/orders/view/${id}`)
}
const createOrder = () => {
    router.push(`/orders/create`)
}
</script>
