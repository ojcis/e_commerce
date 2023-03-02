<template>
  <h3 v-if="state.isLoading" class="pt-16 text-3xl font-bold">Loading...</h3>
  <h3 v-if="state.isError" class="pt-16 text-3xl font-bold">Somethin is worong!</h3>
  <table class="table-auto max-w-4xl w-full mx-1 mt-4">
    <thead class="text-xl">
      <tr class="bg-gray-100">
        <th colspan="5" class="text-2xl">Your shopping cart</th>
      </tr>
      <tr class="bg-gray-300">
        <th class="p-2">Product Name</th>
        <th class="p-2">Price</th>
        <th class="p-2">Quantity</th>
        <th class="p-2">Total Price</th>
        <th></th>
      </tr>
    </thead>
    <tbody class="text-xl">
      <tr v-for="(cartProduct, index) in state.cart" :key="cartProduct.id" :class="index%2 ? 'bg-white' : 'bg-gray-100'">
        <td class="py-2">{{ cartProduct.product.name }}</td>
        <td class="text-center py-2">{{ cartProduct.product.full_price }} EUR</td>
        <td class="text-center py-2">{{ cartProduct.amount }}</td>
        <td class="text-center py-2">{{ cartProduct.full_price }} EUR</td>
        <th class="text-end">
          <button @click="removeProduct(cartProduct.id)" class="bg-red-600 hover:bg-red-400 py-2 px-10 text-white rounded">Remove</button>
        </th>
      </tr>
      <tr>
        <th colspan="5" class="mp-4 text-end text-2xl font-bold">
          Total Price: {{ state.total }} EUR
          <button @click="checkOut" class="bg-red-600 hover:bg-red-400 py-4 px-10 text-white rounded mt-4 ml-4">Check out</button>
        </th>
      </tr>
    </tbody>
  </table>
</template>

<script setup lang="ts">
import { onMounted, reactive, inject } from "vue";
import { useRouter } from "vue-router";
import axios from "axios";
import type { AuthUser } from "@/types/AuthUser";
import type { Cart } from "@/types/Cart";

const router = useRouter();
const url = "http://127.0.0.1:8000/api/v1/cart";
const authUser = inject("authUser") as AuthUser;
const state = reactive({
  cart: [] as Cart[],
  total: null,
  loading: false,
  error: false,
});

const removeProduct = async (id: number) => {
  try {
    const removeProductUrl = "http://127.0.0.1:8000/api/v1/cart/" + id;
    const data = await axios.delete(removeProductUrl, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    await router.replace("/");
    await router.push("/cart");
  } catch (error) {
    console.log("error");
  }
};

const checkOut = async () => {
  try {
    const checkOutUrl = "http://127.0.0.1:8000/api/v1/cart/checkOut"
    const params = {
      user_id: authUser.id,
    };
    const data = await axios.post(checkOutUrl, params, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    authUser.message = data.data.message;
    await router.push("/");
  } catch (error) {
    console.log("error");
  };
};

onMounted(async () => {
  try{
    state.loading = true;
    const params = {
      user_id: authUser.id,
    };
    const data = await axios.post(url, params, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    state.cart = data.data.cart;
    state.total = data.data.total;
    state.loading = false;
  } catch (error) {
    state.error = true;
    console.log("error");
  }
});
</script>
