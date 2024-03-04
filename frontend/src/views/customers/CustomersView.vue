<template>
    <div>
      <button type="button" @click="createCustomer" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Add New Customer</button>
      <VueTable :headers="header" :data="customers" :keys="keys" dark>
        <template #th>
              <th> Actions</th>
          </template>
          <template #td="{ item }">
              <td class="flex">
                <button type="button" @click="viewProduct(item.id)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">View</button>
                <button type="button" @click="editCustomer(item.id)" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Edit</button>
                <button type="button" @click="deleteCustomer(item.id)" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Delete</button>
              </td>
          </template>
      </VueTable>
      
    </div>
  </template>
  
  <script setup>
  import { VueTable } from "@harv46/vue-table";
  import "@harv46/vue-table/dist/style.css"
  import axios from "axios";
  import { useRouter } from "vue-router";
  
  const router = useRouter();
  
  const header = ["Name", "Code", 'Address', 'Contact No']
  const keys=["name", "code", 'address', 'contact']
  
  const editCustomer = (customerId) => {
    router.push(`/customers/edit/${customerId}`)
  }
  
  const deleteCustomer = async (customerId) => {
    try {
      await axios.delete(`http://localhost:8000/api/customers/${customerId}`)
     router.go(0);
    } catch (error) {
      console.error('Error deleting customer: ', error)
    }
  }

    import { onMounted, ref } from 'vue';

    const customers = ref([])

    onMounted(async () => {
        await fetchCustomers();
    })

    const fetchCustomers = async () => {
        try{
            const response = await axios.get(`http://localhost:8000/api/customers`)
            customers.value = response.data.data
        } catch (error) {
            console.error('Error fetching customers', error)
        }
    }
    const createCustomer =() => {
      router.push('/customers/create')
    }


  </script>