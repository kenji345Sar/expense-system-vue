import './bootstrap';

// Alpine.js 読み込み
import Alpine from 'alpinejs';
window.Alpine = Alpine;
Alpine.start();

// Vue 読み込み
import { createApp } from 'vue';
import BusinessTripForm from './components/BusinessTripForm.vue';
import BusinessTripEditForm from './components/BusinessTripEditForm.vue'
import TransportationForm from './components/TransportationForm.vue'
import ExpenseForm from './components/ExpenseForm.vue';
import FormRow from './components/FormRow.vue';
import EntertainmentForm from './components/EntertainmentForm.vue';
import SuppliesForm from './components/SuppliesForm.vue';
import ExpenseFormUnify from './components/ExpenseFormUnify.vue';





const app = createApp({});
app.component('business-trip-form', BusinessTripForm);
app.component('business-trip-edit-form', BusinessTripEditForm);
app.component('transportation-form', TransportationForm);
app.component('expense-form', ExpenseForm);
app.component('form-row', FormRow);
app.component('supply-form', SuppliesForm);
app.component('entertainment-form', EntertainmentForm);
app.component('expense-form-unify', ExpenseFormUnify);


app.mount('#app');
