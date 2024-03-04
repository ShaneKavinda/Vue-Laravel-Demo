<template>
    <div class="flex justify-center items-center min-h-screen">
      <div class="block max-w-6xl bg-white p-6 shadow-md rounded-lg">
        <form @submit.prevent="saveOrder">
          <div class="space-y-6">
            <div class="border-b border-gray-200 pb-6">
              <h2 class="text-lg font-semibold mb-2">Create Order</h2>
              <p class="text-sm text-gray-500">Enter details for the Order</p>
            </div>            
            <div class="overflow-x-auto">
                <select v-model="order.customer" class="w-full flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <option value="">Select Customer</option>
                        <option v-for="customer in customers" :key="customer.id" :value="customer.id">{{ customer.name }}</option>
            </select>
            <button type="button" @click="addProduct" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Add Product</button>
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Free</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Discount(%)</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Sub Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>                    
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="(product, index) in order.products" :key="index">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <select v-model="product.product_id" class="w-full flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <option value="">Select Product</option>
                        <option v-for="p in products" :key="p.id" :value="p.id">{{ p.name }}</option>
                        </select>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                      <input v-model="product.quantity" type="number" min="1" class="w-full flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md" @change="quantityChanged(product)">
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.free }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.amount }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="w-full flex rounded-md shadow-sm sm:max-w-md" >{{ product.discount }}</span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="w-full flex rounded-md shadow-sm sm:max-w-md">{{ product.subtotal }}</span>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap">
                      <button type="button" class="text-red-600" @click="removeProduct(index)">Remove</button>
                    </td>
                  </tr>
                </tbody>
                <div class="flex justify-end space-x-4">
                <label for="net_amount">Net Amount</label>
                <span class="w-max flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">{{ order.net_amount }}</span>
            </div>
              </table>
            </div>
            

            <div class="flex justify-end space-x-4">
              
              <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save Order</button>
              <button type="button" @click="back" class="px-4 py-2 bg-indigo-600 text-white rounded-md shadow-sm hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Cancel</button>
            </div>

          </div>
        </form>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, nextTick } from 'vue';
  import axios from 'axios';
  import { useRouter } from 'vue-router';
  
  const order = ref({
    customer: '',
    products: [{ product_id: '', quantity: 0, free: 0, amount: 0, discount: 0, subtotal: 0  }],
    net_amount: 0
  });
  
  const router = useRouter();
  const products = ref([]);
  const customers = ref([])


  const fetchProducts = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/products');
    products.value = response.data.data;
  } catch (error) {
    console.error('Error fetching Products: ', error);
  }
};

const fetchCustomers = async () => {
  try {
    const response = await axios.get('http://localhost:8000/api/customers');
    customers.value = response.data.data;
  } catch (error) {
    console.error('Error fetching customers: ', error);
  }
};

onMounted(async () => {
  await Promise.all([fetchProducts(), fetchCustomers()]);
});    
  

const back = () => {
  router.push('/orders')
}
const addProduct = () => {
    order.value.products.push({ product_id: '', quantity: 0, free: 0, amount: 0, discount: 0, subtotal: 0  });
};
  
const removeProduct = (index) => {
    order.value.products.splice(index, 1);
};
  
  const getProductById = (productId) => {
    return products.value.find(product => product.id === productId);
  };
  
  const saveOrder = async () => {
    try {
      const jsonData = JSON.stringify(order.value);
      const response = await axios.post('http://localhost:8000/api/orders', jsonData, {
        headers: { 'Content-Type': 'application/json' }
      });
      console.log('Order created successfully', response.data);
      router.push('/orders');
    } catch (error) {
      console.error('Error creating the Order: ', error);
    }
  };
  
  fetchProducts();


  const calculateNetAmount = () => {
    var net_amount = 0
    order.value.products.forEach(product => {
        net_amount += product.subtotal
    });
    console.log('net amount: ', net_amount)
    return net_amount
}


  const quantityChanged = async (product) => {
  try {
    // Fetch free issue, product price and discount concurrently
    const [freeIssueResponse, priceResponse] = await Promise.all([
      axios.get(`http://localhost:8000/api/free_issues/product/${product.product_id}`),
      axios.get(`http://localhost:8000/api/products/${product.product_id}`),
    ]);

    const freeIssue = freeIssueResponse.data;
    const productData = priceResponse.data;

    

    console.log('freeIssue for the product:', freeIssue);
    console.log('Product data:', productData);
    

    if (freeIssue) {
      if (freeIssue.type === 'flat') {
        product.free = freeIssue.free_quantity;
      } else if (freeIssue.type === 'multiple') {
        product.free = parseInt(product.quantity / freeIssue.purchase_quantity * freeIssue.free_quantity);
      }
    } else {
      product.free = 0;
    }

    // Set product price
    product.amount = productData.price * product.quantity;

    // Set the product Net Total
    const discountResponse = axios.post(`http://localhost:8000/api/discounts/${product.product_id}`, { "quantity" : product.quantity }, { 
        headers : {
            'Content-Type' : 'application/json',
        }
    }).then(response => {
        console.log(response.data)
        product.discount = response.data
        product.subtotal = product.amount - (product.amount * product.discount / 100)
        order.value.net_amount = calculateNetAmount()
    });

  } catch (error) {
    console.error('Error fetching data:', error);
  }

  console.log('Product:', product);
};

  </script>
  