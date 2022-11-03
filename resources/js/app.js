import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import VueSweetalert2 from 'vue-sweetalert2';
import Toast, { POSITION } from "vue-toastification";
import 'sweetalert2/dist/sweetalert2.min.css';
import "vue-toastification/dist/index.css";
import "https://js.stripe.com/v3/";


const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Laravel';
const options = {
    position: POSITION.TOP_RIGHT
};
createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .use(VueSweetalert2)
            .use(Toast, options)
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563' });
