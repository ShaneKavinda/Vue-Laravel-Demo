import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CustomersView from '../views/customers/CustomersView.vue'
import ProductsView from '../views/products/ProductsView.vue'
import CreateCustomers from '../views/customers/CreateCustomers.vue'
import CreateProduct from '../views/products/CreateProduct.vue'
import EditProductView from '../views/products/EditProductView.vue'
import EditCustomers from '../views/customers/EditCustomers.vue'
import FreeIssues from '../views/FreeIssues/FreeIssues.vue'
import CreateFreeIssue from '../views/FreeIssues/CreateFreeIssue.vue'
import EditFreeIssue from '../views/FreeIssues/EditFreeIssue.vue'
import Discounts from '../views/discount/Discounts.vue'
import CreateDiscount from '../views/discount/CreateDiscount.vue'
import EditDiscount from '../views/discount/EditDiscount.vue'
import Orders from '../views/orders/Orders.vue'
import CreateOrder from '../views/orders/CreateOrder.vue'
import OrderView from '../views/orders/OrderView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView
    },
    {
      path: '/customers',
      name: 'customers',
      component: CustomersView
    },
    {
      path: '/customers/create',
      name: 'customers-create',
      component: CreateCustomers
    },
    {
      path: '/customers/edit/:id',
      name: 'edit-customers',
      component: EditCustomers,
      props: true
    },
    {
      path: '/products',
      name: 'products',
      component: ProductsView
    },
    {
      path: '/products/edit/:id',
      name: 'edit-product',
      component: EditProductView,
      props: true
    },
    {
      path: '/products/create',
      name: 'create-product',
      component: CreateProduct
    },
    {
      path: '/free_issues',
      name: 'free-issues',
      component: FreeIssues
    },
    {
      path:'/free_issues/create',
      name: 'create-free-issue',
      component: CreateFreeIssue
    },
    {
      path:'/free_issues/edit/:id',
      name: 'edit-free-issue',
      component: EditFreeIssue,
      props: true
    },
    {
      path: '/discounts/',
      name: 'discounts',
      component: Discounts
    },
    {
      path: '/discounts/edit/:id',
      name: 'edit-discounts',
      component: EditDiscount,
      props: true
    },{
      path:'/discounts/create',
      name: 'create-discount',
      component: CreateDiscount
    },
    {
      path: '/orders',
      name: 'orders',
      component: Orders
    },
    {
      path: '/orders/create',
      name: 'create-order',
      component: CreateOrder
    },
    {
      path: '/orders/view/:id',
      name: 'view-order',
      component: OrderView
    }    
  ]
})

export default router
