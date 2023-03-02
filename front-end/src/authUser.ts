import type { AuthUser } from "@/types/AuthUser";
import { reactive } from "vue";

export const authUser: AuthUser = reactive({
  token: sessionStorage.getItem("token") ?? "",
  message: "",
  name: "",
  id: null,
  admin: false,
});
