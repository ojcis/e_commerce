import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import "./assets/style.css";
import { authUser } from "@/authUser";

const app = createApp(App);

app.provide("authUser", authUser);

app.use(router);

app.mount("#app");
