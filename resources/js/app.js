import { createApp, h } from 'vue';
import { createInertiaApp, Link } from '@inertiajs/inertia-vue3';
import route from 'ziggy';
import Main from './Shared/Layouts/Main';
import Admin from './Shared/Layouts/Admin';

createInertiaApp({
    resolve: name => {
        let page = require(`./Pages/${name}`).default;

        if (page.layout === undefined) {
            page.layout = name.includes('Admin') ? Admin : Main;
        }

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
