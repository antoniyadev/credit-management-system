import { createRouter, createWebHistory } from 'vue-router';

import CreditsIndex from '@/components/Credits/Index.vue'
import CreditsCreate from '@/components/Credits/Create.vue'
import PaymentsCreate from '@/components/Payments/Create.vue'
import RecipientsCreate from '@/components/Recipients/Create.vue'

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
        meta: {title: 'Add new credit'},
    },
    {
        path: '/recipients/create',
        name: 'recipients.create',
        component: RecipientsCreate,
        meta: {title: 'Add new recipient'}
    },
    {
        path: '/payments/create/:credit_id?',
        name: 'payments.create',
        component: PaymentsCreate,
        meta: {title: 'Add new payment'},
    },
]

export default createRouter({
    history: createWebHistory(),
    routes
})
