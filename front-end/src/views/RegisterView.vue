<template>
  <div class="max-w-2xl bg-white shadow-md rounded-xl px-8 pt-6 pb-8 my-4 w-full">
    <h2 class="text-2xl">Register</h2>
    <p class="mb-2 text-red-600">{{ state.error }}</p>
    <form @submit.prevent="submit">
      <div class="mb-4">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="username">
          Name
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" v-model="state.name.value" required id="username" type="text" placeholder="Username">
        <p class="mb-2 text-red-600">{{ state.name.error }}</p>
      </div>
      <div class="mb-4">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="email">
          Email
        </label>
        <input class="shadow appearance-none border rounded w-full py-2 px-3 text-grey-darker" v-model="state.email.value" required id="email" type="email" placeholder="Email">
        <p class="mb-2 text-red-600">{{ state.email.error }}</p>
      </div>
      <div class="mb-6">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="password">
          Password
        </label>
        <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker" v-model="state.password.value" required id="password" type="password" placeholder="******************">
        <p class="mb-2 text-red-600">{{ state.password.error }}</p>
      </div>
      <div class="mb-6">
        <label class="block text-grey-darker text-sm font-bold mb-2" for="password_confirmation">
          Confirm password
        </label>
        <input class="shadow appearance-none border border-red rounded w-full py-2 px-3 text-grey-darker mb-3" v-model="state.password_confirmation" required id="password_confirmation" type="password" placeholder="******************">
      </div>
      <div class="flex flex-wrap items-center justify-between">
        <button class="bg-red-600 hover:bg-red-40 py-2 px-10 text-white rounded" type="submit">Register</button>
        <nav>
          <RouterLink class="text-sm hover:text-blue-900 whitespace-nowrap" to="/login">Already have account?</RouterLink>
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
const url = "http://127.0.0.1:8000/api/v1/register";
const router = useRouter();
const state = reactive({
  name: {
    value: "",
    error: "",
  },
  email: {
    value: "",
    error: "",
  },
  password: {
    value: "",
    error: "",
  },
  password_confirmation: "",
  error: "",
});

const submit = async () => {
  try {
    const params = {
      name: state.name.value,
      email: state.email.value,
      password: state.password.value,
      password_confirmation: state.password_confirmation,
    };
    const data = await axios.post(url, params);
    if (data.data.token) {
      authUser.message = data.data.message;
      authUser.token = data.data.token;
      authUser.name = data.data.user_name;
      authUser.id = data.data.user_id;
      sessionStorage.setItem("token", authUser.token);
      await router.push("/");
    }
  } catch (error) {
    if (axios.isAxiosError(error)) {
      const errors = error.response?.data?.errors;
      state.name.error = errors.name?.[0];
      state.email.error = errors.email?.[0];
      state.password.error = errors.password?.[0];
    } else {
      state.error = "Something went wrong";
    }
  }
  state.password.value = "";
  state.password_confirmation = "";
};
</script>