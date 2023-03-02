import { createRouter, createWebHistory } from "vue-router";
import { authUser } from "@/authUser";
import HomeView from "../views/HomeView.vue";
import ProductsView from "../views/ProductsView.vue";
import ProductView from "../views/ProductView.vue";
import ProductUpdateView from "../views/ProductUpdateView.vue";
import NewProductView from "../views/NewProduct.vue";
import LoginView from "../views/LoginView.vue";
import RegisterView from "../views/RegisterView.vue";
import CartView from "../views/CartView.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: "/",
      name: "home",
      component: HomeView,
    },
    {
      path: "/register",
      name: "register",
      component: RegisterView,
    },
    {
      path: "/login",
      name: "login",
      component: LoginView,
    },
    {
      path: "/products",
      name: "products",
      component: ProductsView,
      meta: {
        authorized: true,
      },
    },
    {
      path: "/products/:id",
      component: ProductView,
      meta: {
        authorized: true,
      },
    },
    {
      path: "/products/:id/update",
      component: ProductUpdateView,
      meta: {
        authorized: true,
      },
    },
    {
      path: "/products/create",
      name: "createProduct",
      component: NewProductView,
      meta: {
        authorized: true,
      },
    },
    {
      path: "/cart",
      name: "cart",
      component: CartView,
      meta: {
        authorized: true,
      },
    },
  ],
});

router.beforeEach((to, from, next) => {
  if (to.matched.some((record) => record.meta.authorized)) {
    if (authUser.token) {
      next();
    } else {
      next({ name: "login" });
    }
  } else {
    next();
  }
});

export default router;
