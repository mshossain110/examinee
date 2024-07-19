import { usePage } from "@inertiajs/vue3";
import { User } from "@/types";

export default function useAuth() {
     const user: User = usePage().props.auth.user;

     return {
          user,
          authenticated: !! user,
          roles: {
               superAdmin: true,
               admin: true,
               moderator: false,
               editor: false,
               user: false,
          },
     }
}