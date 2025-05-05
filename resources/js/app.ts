import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { BootstrapVueNextResolver } from 'bootstrap-vue-next';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createPinia } from 'pinia';
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import { createApp, DefineComponent, h } from 'vue';
import Toast from 'vue-toastification';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

import 'bootstrap-vue-next/dist/bootstrap-vue-next.css';
import 'bootstrap/dist/css/bootstrap.css';
import 'vue-toastification/dist/index.css';

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob<DefineComponent>('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        const pinia = createPinia();
        pinia.use(piniaPluginPersistedstate);

        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(pinia)
            .use(BootstrapVueNextResolver)
            .use(Toast)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
