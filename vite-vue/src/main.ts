import { createApp } from "vue";
import { createPinia } from "pinia";

import { router } from "./router/router.js";
import App from "./App.vue";
import "./style.css";

/* import the fontawesome core */
import { library } from '@fortawesome/fontawesome-svg-core'

/* import font awesome icon component */
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

/* import specific icons */
import { faChevronRight, faChevronLeft, faCheck } from '@fortawesome/free-solid-svg-icons'

/* add icons to the library */
library.add(faChevronRight, faChevronLeft, faCheck)

const pinia = createPinia();

createApp(App)
.use(router)
.use(pinia)
.component('font-awesome-icon', FontAwesomeIcon)
.mount("#app");
