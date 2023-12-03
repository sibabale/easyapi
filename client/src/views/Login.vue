<template>
  <div>
    <h1>Login</h1>
    <form @submit.prevent="login">
      <label
        >Email:
        <input v-model="email" type="email" required />
      </label>
      <label
        >Password:
        <input v-model="password" type="password" required />
      </label>
      <button type="submit">Login</button>
    </form>
  </div>
</template>

<script lang="ts">
import axios from 'axios'
import { defineComponent, ref } from 'vue'

export default defineComponent({
  setup() {
    const email = ref('')
    const password = ref('')
    const authStore = useAuthStore()

    const login = async () => {
      try {
        const response = await axios.post('/login', {
          email: email.value,
          password: password.value
        })
        const { user, token } = response.data
        authStore.setUser(user, token)
        // Redirect to dashboard or another route
      } catch (error) {
        console.error('Login failed', error)
      }
    }

    return { email, password, login }
  }
})
</script>
