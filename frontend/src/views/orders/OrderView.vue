
<template>
  <div class="flex justify-center items-center min-h-screen" id="element-to-export">
    <div class="block max-w-6xl bg-white p-6 shadow-md rounded-lg">
      <div class="space-y-6">
        <div class="border-b border-gray-200 pb-6">
          <h2 class="text-lg font-semibold mb-2">Invoice No:  {{ order.id }}</h2>
          <p class="text-sm text-gray-500">Customer:  {{ customer.name }}</p>
          <div class="flex justify-end space-x-4">
            <label for="net_amount">Net Amount</label>
            <span class="text-m text-gray-900">{{ order.net_amount }}</span>
          </div> 
        </div>            
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Free</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount(%)</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Total</th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
            <tr v-for="(product, index) in order.products" :key="index">
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.name }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.pivot.quantity }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.pivot.free }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.pivot.amount }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.pivot.discount }}</span>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.pivot.subtotal }}</span>
              </td>
            </tr>
          </tbody>    
        </table>
        <div class="flex justify-end space-x-2">
          <button @click="printToPdf" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Download Invoice</button>
          <button @click="export2Excel" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Export to Excel</button>
          <button @click="back" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Back to Orders</button>
        </div>
      </div>
    </div>
  </div>
</template> 

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import { useRouter } from 'vue-router';

const router = useRouter();

const order = ref({});
const customer = ref({});

const fetchOrder = async (id) => {
  try {
    const response = await axios.get(`http://localhost:8000/api/orders/${id}`);
    order.value = response.data.order;
    console.log('order: ', order.value)

    // Extract the customer ID from the order
    const customerId = order.value.customer_id;

    // Fetch customer details using the customer ID
    const customerResponse = await axios.get(`http://localhost:8000/api/customers/${customerId}`);
    customer.value = customerResponse.data;
    console.log(customer.value)

  } catch (error) {
    console.error('Error fetching order:', error);
  }
};

const printToPdf = () => {
  html2pdf(document.getElementById('element-to-export'), {
    margin: 1,
    filename: "invoice.pdf"
  });
};

const export2Excel = async () => {
  axios.get(`http://localhost:8000/api/orders/${order.value.id}/export-excel`, {
    responseType: 'blob',
  }).then((response) => {
    const url = URL.createObjectURL(new Blob([response.data]))
    const link = document.createElement('a')
    link.href = url
    link.setAttribute(
      'download',
      `invoice_${order.value.id}-${new Date().toLocaleDateString()}.xlsx`
    )
    document.body.appendChild(link)
    link.click()
  })
};


onMounted(async () => {
  const id = router.currentRoute.value.params.id;
  await fetchOrder(id);
});

const back = () => {
  router.push('/orders');
};
</script>
