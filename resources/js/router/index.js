import { createRouter, createWebHistory } from 'vue-router';

const routes = [
    {
        path: '/',
        redirect: '/principal',
        component: () => import('../layouts/website.vue'),
        children: [
            {
                name: 'principal',
                path: 'principal',
                component: () => import('../web/ContactoCom.vue'),
            },
            {
                name: 'home',
                path: 'home',
                component: () => import('../web/HomeCom.vue')
            }
        ],
    },
    {
        path: '/App',
        redirect: '/dashboard',
        component: () => import('../layouts/aplication.vue'),
        children: [
            {
                name: 'dashboard',
                path: '/dashboard',
                component: () => import('../web/ContactoCom.vue'),
            },
            {
                name: 'homesite',
                path: '/homesite',
                component: () => import('../web/HomeCom.vue')
            }
        ]
    }
];

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
});

export default router;
