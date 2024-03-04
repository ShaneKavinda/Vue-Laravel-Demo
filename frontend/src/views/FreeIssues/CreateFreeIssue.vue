<script setup>
    import { ref, onMounted } from 'vue';
    import axios from 'axios';
    import { useRouter } from 'vue-router';


    const freeIssue = ref({
    name: '',
    type: '',
    purchase_product: '',
    free_product: '',
    purchase_quantity: '',
    free_quantity: '',
    lower_limit: '',
    upper_limit: ''
    });

    const router = useRouter();

    const products = ref([])
    const freeProduct = ref('')

    axios.get('http://localhost:8000/api/products')
        .then(response => {
            products.value = response.data.data;
            // console.log("products: ", products.value)
        })
        .catch (error =>{
            console.error(error)
        })

    const setFreeProduct = () => {
        const selectedProduct = products.value.find(product=>product.id === freeIssue.value.purchase_product);
        if (selectedProduct){
           freeIssue.value.free_product = selectedProduct.id;
           freeProduct.value = selectedProduct.name
        }
    }

    const backToCustomers =  () => {
        router.push('/free_issues')
    }
    const createFreeIssue = () => {
        // Extract the values from the fields
        const { name, type, purchase_product, free_product, purchase_quantity, free_quantity, lower_limit, upper_limit} = freeIssue.value;
        console.log(freeIssue.value)
        // Prepare data for the POST request
        const updatedFreeIssue = {   
            name,
            type,
            purchase_product,
            free_product,
            purchase_quantity,
            free_quantity,
            lower_limit,
            upper_limit
        }
        console.log("updated values: ", updatedFreeIssue)

        // JSON stringify the payload
        const jsonData = JSON.stringify(updatedFreeIssue);

        // Send the POST request to the API Endpoint
        axios.post(`http://localhost:8000/api/free_issues`, jsonData, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            console.log('Free Issue created successfully', response.data);
            // Redirect the user to the ProductsView.vue
            router.push('/free_issues');
        })
        .catch(error => {
            console.error('Error creating the Free Issue: ', error);
        });
    }
    
</script>


<template>
    <div class="flex justify-center items-center min-h-screen">
        <div class="block max-w-sm rounded-lg bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] ">
        <form @submit.prevent="createFreeIssue">
            <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <h2 class="text-base font-semibold leading-7 ">Free Issue</h2>
                <p class="mt-1 text-sm leading-6 ">Enter details for the Customer</p>

                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                <div class="sm:col-span-4">
                    <label for="name" class="block text-sm font-medium leading-6 ">Free Issue Name</label>
                    <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" name="name" id="name" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="freeIssue.name"/>
                    </div>
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="type" class="block text-sm font-medium leading-6">Type</label>
                    <div class="mt-2">          
                        <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com --> 
                        <select data-te-select-init class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md " v-model="freeIssue.type">
                        <option value="flat">Flat</option>
                        <option value="multiple">Multiple</option>
                        </select>
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="purchase_product" class="block text-sm font-medium leading-6 text-gray-900">Purchase Product</label>
                    <div class="mt-2">
                        <select class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md" v-model="freeIssue.purchase_product" @change="setFreeProduct">
                        <option v-for="product in products" :value="product.id" :key="product.id">{{ product.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="sm:col-span-4">
                    <label for="free_product" class="block text-sm font-medium leading-6 text-gray-900">Free Product</label>
                    <div class="mt-2">
                        <input type="text" name="free_product" id="free_product" autocomplete="free_product" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-m m:leading-6" v-model="freeProduct"  readonly>
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="purchase_quantity" class="block text-sm font-medium leading-6 text-gray-900">Purchase Quantity</label>
                    <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" name="purchase_quantity" id="purchase_quantity" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="freeIssue.purchase_quantity"/>
                    </div>
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="purchase_quantity" class="block text-sm font-medium leading-6 text-gray-900">Free Quantity</label>
                    <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" name="free_quantity" id="free_quantity" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="freeIssue.free_quantity"/>
                    </div>
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="purchase_quantity" class="block text-sm font-medium leading-6 text-gray-900">Upper Limit</label>
                    <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" name="upper_limit" id="upper_limit" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="freeIssue.upper_limit"/>
                    </div>
                    </div>
                </div>

                <div class="sm:col-span-4">
                    <label for="purchase_quantity" class="block text-sm font-medium leading-6 text-gray-900">Lower Limit</label>
                    <div class="mt-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" name="lower_limit" id="lower_limit" autocomplete="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" v-model="freeIssue.lower_limit"/>
                    </div>
                    </div>
                </div>



            </div>  
            </div>

            <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" @click="backToCustomers" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
            </div>
        </form>
        </div>
    </div>
</template>

