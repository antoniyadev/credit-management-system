import { createRouter, createWebHistory } from 'vue-router';

import CreditsIndex from '@/components/Credits/Index.vue'
import CreditsCreate from '@/components/Credits/Create.vue'
import PaymentsCreate from '@/components/Payments/Create.vue'

const routes = [
    {
        path: '/',
        name: 'credits.index',
        component: CreditsIndex,
        meta: {title: 'Credits'}
    },
    {
        path: '/credits/create',
        name: 'credits.create',
        component: CreditsCreate,
        meta: {title: 'Add new credit'}
    },
    {
        path: '/payments/create/:credit_id?',
        name: 'payments.create',
        component: PaymentsCreate,
        meta: {title: 'Add new payment'},
        props: true,
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
