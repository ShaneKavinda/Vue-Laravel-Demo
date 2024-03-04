<template>
  <div>
    <button type="button" @click="createFreeIssue" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Add New Free Issue</button>
    <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com --> 
    <div class="flex flex-col">
      <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
          <div class="overflow-hidden">
            <table class="min-w-full text-left text-sm font-light">
              <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                  <th scope="col" class="px-6 py-4">Name</th>
                  <th scope="col" class="px-6 py-4">Type</th>
                  <th scope="col" class="px-6 py-4">Purchase Product</th>
                  <th scope="col" class="px-6 py-4">Free Product</th>
                  <th scope="col" class="px-6 py-4">Purchase Quantity</th>
                  <th scope="col" class="px-6 py-4">Free Quantity</th>
                  <th scope="col" class="px-6 py-4">Lower Limit</th>
                  <th scope="col" class="px-6 py-4">Upper Limit</th>
                  <th scope="col" class="px-6 py-4"> Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="item in freeIssues"
                  class="border-b transition duration-300 ease-in-out hover:bg-neutral-100 dark:border-neutral-500 dark:hover:bg-neutral-600">
                  <td class="whitespace-nowrap px-6 py-4 font-medium">{{ item.name }}</td>
                  <td class="whitespace-nowrap px-6 py-4">{{ item.type}}</td>
                  <td class="whitespace-nowrap px-6 py-4">{{item.purchase_product.name}}</td>
                  <td class="whitespace-nowrap px-6 py-4">{{item.free_product.name}}</td>
                  <td class="whitespace-nowrap px-6 py-4">{{item.purchase_quantity}}</td>
                  <td class="whitespace-nowrap px-6 py-4">{{item.free_quantity}}</td>
                  <td class="whitespace-nowrap px-6 py-4">{{item.lower_limit}}</td>
                  <td class="whitespace-nowrap px-6 py-4">{{item.upper_limit}}</td>
                  <td class="flex">
                    <button type="button" @click="editFreeIssue(item.id)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Edit</button>
                    <button type="button" @click="deleteFreeIssue(item.id)" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
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
const freeIssues = ref([]);

onMounted(async () => {
  await fetchFreeIssues();
});

const fetchFreeIssues = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/free_issues');
    freeIssues.value = response.data;
    console.log(freeIssues.value);
  } catch (error) {
    console.error('Error fetching Free Issues: ', error);
  }
};

const createFreeIssue = () => {
  router.push('/free_issues/create');
};

const editFreeIssue = (id) => {
  router.push(`/free_issues/edit/${id}`);
};

const deleteFreeIssue = async (id) => {
  try {
    await axios.delete(`http://localhost:8000/api/free_issues/${id}`);
    await fetchFreeIssues(); // Refresh the list of free issues
  } catch (error) {
    console.error('Error deleting Free Issue: ', error);
  }
};
</script>
