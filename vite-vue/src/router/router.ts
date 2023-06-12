import { createRouter, createWebHistory } from "vue-router";
import jwt from 'jwt-decode' 

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
    component: () => import("../views/movie/Movies.vue"),
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
    meta: {
      requiresAuthAdmin: true
    }
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
    meta: {
      requiresAuthAdmin: true
    }
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
    meta: {
      requiresAuth: true
    }
  },
  {
    path: "/offres/",
    name: "offers",
    component: () => import("../views/stripe/Offers.vue"),
  }
];

export const router = createRouter({
  history: createWebHistory(),
  routes
})

router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('access_token');

  if (to.meta.requiresAuth) {
    if (!token) {
      next('/login');
    } else {
      next();
    }
  } else if (to.meta.requiresAuthAdmin) {
    if (token) {
      const decodedToken = jwt(token);
      if (decodedToken.roles.includes('ROLE_ADMIN')) {
        next();
      } else{
        next('/login');
      }
    } else{
      next('/login');
    }
  } else if (to.meta.requiresCompanyRole) {
    if (token) {
      const decodedToken = jwt(token);
      if (decodedToken.roles.includes('ROLE_COMPANY')) {
        next();
      } else{
        next('/login');
      }
    } else{
      next('/login');
    }
  }
  else {
    next();
  }
});

/*

router.beforeEach((to, from, next) => {
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

