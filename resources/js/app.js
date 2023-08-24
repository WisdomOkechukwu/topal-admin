import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { Link } from '@inertiajs/vue3'
import VueApexCharts from "vue3-apexcharts"
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'


createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {
        let app = createApp({ render: () => h(App, props) });
        app.use(plugin);
        app.use(VueApexCharts);
        app.component('Link', Link);
        app.component("apexchart", VueApexCharts);
        app.component('VueDatePicker', VueDatePicker);
        app.mount(el);
    },
})
