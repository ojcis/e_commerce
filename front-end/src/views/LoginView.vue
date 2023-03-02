<template>
  <div class="max-w-2xl bg-white shadow-md rounded-xl px-8 pt-6 pb-8 my-4 w-full">
    <h2 class="text-2xl">Login</h2>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
          Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" v-model="state.email" required id="email" type="email" placeholder="Email">
      </div>
      <p class="mb-2 text-red-600">{{ state.error }}</p>
      <div class="mb-6">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" v-model="state.password" required id="password" type="password" placeholder="******************">
      </div>
      <div class="flex flex-wrap items-center justify-between">
        <button class="bg-red-600 hover:bg-red-400 py-2 px-10 text-white rounded" type="submit">Login</button>
        <nav>
          <RouterLink class="text-sm hover:text-blue-900 whitespace-nowrap" to="/register">Dont have account?</RouterLink>
        </nav>
      </div>
    </form>
  </div>
</template>

<script setup lang="ts">
import { reactive, inject } from "vue";
import axios from "axios";
import { useRouter } from "vue-router";
import type { AuthUser } from "@/types/AuthUser";

const authUser = inject("authUser") as AuthUser;
const url = "http://127.0.0.1:8000/api/v1/login";
const router = useRouter();
const state = reactive({
  email: "",
  password: "",
  error: "",
});

const submit = async () => {
  try {
    const params = {
      email: state.email,
      password: state.password,
    };
    const data = await axios.post(url, params);
    state.error = data.data.message;
    if (data.data.token) {
      authUser.token = data.data.token;
      authUser.message = data.data.message;
      authUser.name = data.data.user_name;
      authUser.id = data.data.user_id;
      if (authUser.id == 1) {
        authUser.admin = true;
      }
      sessionStorage.setItem("token", authUser.token);
      await router.push("/");
    }
  } catch (error) {
    state.error = "Something went wrong!"
  }
  state.password = "";
};
</script>