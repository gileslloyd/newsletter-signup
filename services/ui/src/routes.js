import VueRouter from 'vue-router';

let routes = [
    {
        path: '/',

        component: require('./views/Signup.vue').default,

        meta: { requiresAuth: true }
    },
];

let router = new VueRouter({routes});

export default router;
