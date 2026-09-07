import { useAuthStore } from "../stores/AuthStore";

export default function auth({ next, router }) {
  const authStore = useAuthStore();

  if (!authStore.token) {
    return router.push({ name: "login" });
  }

  return next();
}