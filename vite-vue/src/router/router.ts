import { createRouter, createWebHistory } from "vue-router";
import filmDb from "../../films.json";
import ErrorView from "../views/stripe/Error.vue";
import SuccessView from "../views/stripe/Success.vue";
import Stripe from "../views/stripe/Stripe.vue";

const routes = [
  {
    path: "/",
    name: "home",
    component: () => import("../views/movie/Movies.vue"),
  },
  {
    path: "/about",
    name: "about",
    component: () => import("../views/about/About.vue"),
  },
  {
    path: "/login",
    name: "login",
    component: () => import("../views/auth/Login.vue"),
  },
  {
    path: "/register",
    name: "register",
    component: () => import("../views/auth/Register.vue"),
  },
  {
    path: "/movies",
    name: "movies",
    component: () => import("../views/movie/MovieForm.vue"),
  },
  {
    path: "/company/products",
    name: "company",
    component: () => import("../views/company/List.vue"),
    meta: { requiresCompanyRole: true }
  },
  {
    path: "/movies/:id",
    name: "movie.show",
    component: () => import("../views/movie/MovieItem.vue"),
  },
  {
    path: "/products",
    name: "products",
    component: () => import("../views/product/ProductList.vue"),
  },
  {
    path: "/admin/review",
    name: "review",
    component: () => import("../views/review/ReviewForm.vue"),
  },
  {
    path: "/admin/review_validation",
    name: "review_validation",
    component: () => import("../views/review/ReviewToValidate.vue"),
  },
  {
    path: "/demo/:id",
    name: "demo.show",
    component: () => import("../views/Demo.vue"),
    beforeEnter(to: any, from: any) {
      const exists = filmDb.find((film) => film.id === parseInt(to.params.id));
      if (!exists) {
        return { name: "not-found" };
      }
    },
  },
  {
    path: "/:pathMatch(.*)*",
    name: "not-found",
    component: () => import("../views/NotFound.vue"),
  },
  {
    path: "/admin/dashboard",
    name: "admin-dashboard",
    component: () => import("../views/adm/Dashboard.vue"),
  },
  {
    path: "/success",
    name: "successview",
    component: () => import("../views/stripe/Success.vue"),
  },
  {
    path: "/error",
    name: "errorview",
    component: () => import("../views/stripe/Error.vue"),
  },
  {
    path: "/payment/:id",
    name: "Payment",
    component: () => import("../views/stripe/Stripe.vue"),
  },
];

export const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    return (
      savedPosition ||
      new Promise((resolve) => {
        setTimeout(() => {
          resolve({ top: 0, left: 0 });
        }, 200);
        // TIMING DEPENDS ON CSS TRANSITION ANIMATION
      })
    );
  },
});
/*router.beforeEach((to, from, next) => {
  const requiresCompanyRole = to.matched.some(record => record.meta.requiresCompanyRole)
  const token = localStorage.getItem("access_token");
  if (token) {
  let payload = (token).split('.')[1];
  let tokenTest = window.atob(payload);
  const values = JSON.parse(tokenTest);
  const roles = values.roles;
  
  if (requiresCompanyRole && roles.includes('ROLE_COMPANY') ){
     
      next() 
    } else {
    
      next('/login')
    }              
  }
})
*/
