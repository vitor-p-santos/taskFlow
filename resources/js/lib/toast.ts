
import { toast } from "vue-sonner";


export function successToast(message: string) {
  
    toast.success(message);
}

export function errorToast(message: string) {
    toast.error(message);
}
