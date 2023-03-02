<template>
  <p v-if="authUser.token" class="flex flex-row-reverse text-white bg-red-600 border border border border-red-400 border-t-0 border-l-0 border-r-0 border-b-2 pr-2 h-7">Logged in as {{authUser.name}}</p>
  <div class="flex justify-between bg-red-600">
    <nav class="flex flex-wrap">
      <NavLink link="/" name="Home" />
      <NavLink v-if="authUser.token" link="/products" name="Products" />
      <NavLink v-if="authUser.admin" link="/products/create" name="Add product" />
    </nav>
    <nav v-if="authUser.token" class="flex flex-wrap-reverse justify-end">
      <NavLink link="/cart" name="Cart" />
      <button @click="logout" class="text-2xl text-white font-semibold px-12 py-3 hover:bg-red-400">Logout</button>
    </nav>
    <nav v-else class="flex flex-wrap justify-end">
      <NavLink link="/register" name="Register" />
      <NavLink link="/login" name="Login" />
    </nav>
  </div>
</template>

<script setup lang="ts">
import NavLink from "@/components/NavLink.vue";
import axios from "axios";
import { useRouter } from "vue-router";
import { inject } from "vue";
import type { AuthUser } from "@/types/AuthUser";

const authUser = inject("authUser") as AuthUser;
const url = "http://127.0.0.1:8000/api/v1/logout";
const router = useRouter();

const logout = async () => {
  try {
    const data = await axios.post(
      url,
      {},
      {
        headers: {
          Authorization: "Bearer " + authUser.token,
        },
      }
    );
    authUser.token = "";
    authUser.message = data.data.message;
    authUser.name = "";
    authUser.id = null;
    authUser.admin = false;
    sessionStorage.clear();
    await router.push("/login");
  } catch (error) {
    console.log("error");
  }
};
</script>