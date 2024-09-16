import './bootstrap';

import { createApp } from 'vue';

// Vuetify
import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/styles';
import { createVuetify } from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';

import App from './components/App.vue';
const vuetify = createVuetify({
    components,
    directives
});

createApp(App).use(vuetify).mount('#app');
