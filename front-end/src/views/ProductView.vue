<template>
  <div class="flex justify-center w-full">
    <h3 v-if="state.message" class="pt-2 text-3xl font-bold">{{ state.message }}</h3>
  </div>
  <div class="flex flex-col max-w-4xl justify-center w-full">
    <div class="flex flex-col w-full bg-red-600 items-center rounded-t-xl mt-4 p-4 shadow-xl">
      <h2 class="text-4xl text-white font-bold text-center">{{ state.product.name }}</h2>
    </div>
    <div class="flex flex-col max-w-4xl w-full bg-white items-center rounded-b-xl p-4 shadow-xl">
      <ul class="flex flex-wrap w-full justify-around items-center my-4">
        <li class="text-center text-2xl my-1">Available:<br>{{ state.product.available}}</li>
        <li class="text-center text-2xl my-1">Price before vat:<br>{{ state.product.price}} EUR</li>
        <li class="text-center text-2xl my-1">Vat ({{state.product.vat_rate}}%):<br>{{ state.product.vat}} EUR</li>
        <li class="text-center text-2xl my-1">Price:<br>{{ state.product.full_price }} EUR</li>
      </ul>
      <div class="flex flex-wrap w-full justify-between mt-10">
        <div class="flex flex-wrap items-end h-full mt-1">
          <router-link v-if="authUser.admin" :to="`/products/${state.product.id}/update`">
            <button class="bg-red-600 hover:bg-red-400 py-4 px-10 text-white rounded mr-1 text-xl ">Update Product</button>
          </router-link>
          <button v-if="authUser.admin" @click="remove" class="bg-red-600 hover:bg-red-400 py-4 px-10 text-white rounded text-xl ">Remove Product</button>
        </div>
        <div class="flex flex-col items-end bg-gray-200 p-2 rounded">
          <h3 class="text-3xl"> Full price: {{ (state.amount * state.product.full_price).toFixed(2) }} EUR</h3>
          <div class="flex flex-wrap justify-end mt-1">
            <p class="self-center text-2xl mr-1">Amount:</p>
            <input v-model="state.amount" type="number" min="1" :max="state.product.available" class="border-2 border-black rounded mr-1 text-center text-2xl w-24" />
            <button @click="addToCart" class="bg-red-600 hover:bg-red-400 py-4 px-10 text-white text-xl rounded">Add to cart</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import { inject, onMounted, reactive } from "vue";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";
import type { Product } from "@/types/Product";
import type { AuthUser } from "@/types/AuthUser";

const url = "http://127.0.0.1:8000/api/v1/products/";
const route = useRoute();
const router = useRouter();
const authUser = inject("authUser") as AuthUser;
const productId = route.params.id;
const state = reactive({
  product: {} as Product,
  amount: 1,
  message: "",
  isLoading: false,
  isError: false,
});

const addToCart = async () => {
  try {
    const addToCartUrl = "http://127.0.0.1:8000/api/v1/cart/add";
    const params = {
      user_id: authUser.id,
      product_id: state.product.id,
      amount: state.amount,
    };
    const data = await axios.post(addToCartUrl, params, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    state.message = data.data.message;
  } catch (error) {
    console.log("error");
  }
};

const remove = async () => {
  try {
    const removeUrl = "http://127.0.0.1:8000/api/v1/products/"
    const data = await axios.delete(removeUrl + productId,{
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    authUser.message = data.data.message;
    await router.push("/");
  } catch (error) {
    console.log( 'error' );
  }
};

onMounted(async () => {
  try {
    const data = await axios.get(url + productId, {
      headers: {
        Authorization: "Bearer " + authUser.token,
      },
    });
    state.product = data.data.data;
    state.product.vat_rate *= 100;
  } catch (error) {
    console.log("error");
  }
});
</script>