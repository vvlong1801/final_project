import axios from "axios";
import { useStorage } from "@vueuse/core";

window.axios = axios;

window.axios.defaults.headers.common["X-Requested-With"] = "XMLHttpRequest";
window.axios.defaults.withCredentials = true;
window.axios.defaults.baseURL = import.meta.env.VITE_BASE_URL;

const accessToken = useStorage("access_token", "");

window.axios.defaults.headers.common[
  "Authorization"
] = `Bearer ${accessToken.value}`;
