import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/vue3';
import route from 'ziggy-js';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import Admin from '@/Shared/Layouts/Admin.vue';
import Main from '@/Shared/Layouts/Main.vue';

createInertiaApp({
    resolve: name => {
        const page = resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));

        page.then(module => {
            if (name.includes('Admin')) {
                module.default.layout = Admin;
            } else {
                module.default.layout = Main;
            }
        });

        return page;
    },
    setup ({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mixin({ methods: { route } })
            .component('InertiaLink', Link)
            .mount(el);
    },
});
