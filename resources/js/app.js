// import './bootstrap';

// import Alpine from 'alpinejs';

// window.Alpine = Alpine;

// Alpine.start();
import './bootstrap';
import { createApp } from 'vue';
import UserIndex from './components/Users/UserIndex.vue';
import UserCreate from './components/Users/UsersCreate.vue';
import UserEdit from './components/Users/UsersEdit.vue';
import ProjectForm from './components/Projects/ProjectForm.vue';
import ProjectEditForm from './components/Projects/ProjectEditForm.vue';
import TableComponent from './components/Projects/IndexPage.vue';

const app = createApp({});
//Users Components
app.component('user-create', UserCreate);
app.component('user-edit', UserEdit);
app.component('user-index', UserIndex);

//Projects Components
app.component('project-form',ProjectForm);
app.component('project-edit-form',ProjectEditForm);
app.component('table-component', TableComponent);
app.mount('#app');