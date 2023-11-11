import { createApp } from 'vue';
import ExampleComponent from './components/ExampleComponent.vue';

import router from './router.js';

const app = createApp({

});

app.component('example-component', ExampleComponent);

app.use(router);
app.mount('#app');
