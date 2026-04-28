import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/tickets',
      name: 'tickets.index',
      component: () => import('../views/Tickets/Index.vue'),
    },
    {
      path: '/tickets/create',
      name: 'tickets.create',
      component: () => import('../views/Tickets/Create.vue'),
    },
    {
      path: '/about',
      name: 'about',
      component: () => import('../views/AboutView.vue'),
    },
  ],
})

export default router
