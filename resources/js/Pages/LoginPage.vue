<template>
  <Head title="Log in" />
    
  <div class="min-h-screen bg-amber-50 flex items-center justify-center p-4">
    <div class="flex flex-col md:flex-row w-full max-w-6xl bg-amber-50 rounded-xl overflow-hidden">
      
      <div class="w-full md:w-1/2 p-8 md:p-12 space-y-6">
        <div class="flex justify-between items-center mb-8 w-full">
            <h1 class="text-2xl font-bold text-indigo-600">Shinta Bakery's Admin</h1>
        </div>
        
        <h2 class="text-4xl md:text-5xl font-black text-gray-900">Login now</h2>
        <p class="text-xl text-gray-800 mt-4">Hi, Welcome back 👋</p>
      

        <form @submit.prevent="submit" class="space-y-6">
          <div class="space-y-2">
            <label class="block text-lg font-semibold text-gray-800">Email</label>
            <input 
              type="email" 
              placeholder="Enter your email id" 
              class="w-full bg-pink-200 border-none rounded-lg px-4 py-3 text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-400"
              v-model="form.email" required
              autofocus
            />
            <div v-if="form.errors.email" class="text-sm text-red-600">
              {{ form.errors.email }}
            </div>
          </div>
          
          <div class="space-y-2">
            <label class="block text-lg font-semibold text-gray-800">Password</label>
            <div class="relative">
              <input 
                :type="showPassword ? 'text' : 'password'" 
                placeholder="Enter your password" 
                class="w-full bg-pink-200 border-none rounded-lg px-4 py-3 text-gray-700 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-pink-400"
                v-model="form.password" required
              />
              <button 
                type="button" @click="togglePassword" 
                class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-700 hover:text-gray-900"
              >
                <svg v-if="!showPassword" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                    <circle cx="12" cy="12" r="3"></circle>
                  </svg>
                  <svg v-else xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                    <line x1="1" y1="1" x2="23" y2="23"></line>
                  </svg>
              </button>
            </div>
            <div v-if="form.errors.password" class="text-sm text-red-600">
              {{ form.errors.password }}
            </div>
          </div>
          
          <div class="flex justify-between items-center">
            <div class="flex items-center">
              <input 
                type="checkbox" 
                id="remember" 
                class="mr-2 h-5 w-5 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                v-model="form.remember" >
              <label for="remember" class="text-gray-800">Remember Me</label>
            </div>
            <Link :href="route('password.request')" class="text-indigo-600 hover:text-indigo-800 font-medium">
              Forgot Password?
            </Link>
          </div>
          
          <button 
            type="submit" class="w-full bg-pink-600 hover:bg-red-700 text-white font-medium py-3 px-4 rounded-lg transition-colors mt-4"
            :class="{ 'opacity-25': form.processing }"
            :disabled="form.processing" >
            Login
          </button>
          
        </form> </div>
      
      <div class="size-22 py-12 px-5 items-center justify-center ">
        <img 
          class="absolute bottom-20"
          src="/images/LandingPage/asset-loginpage.png" 
          alt="Login Illustration" 
        />
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

// Logika untuk show/hide password
const showPassword = ref(false);

const togglePassword = () => {
  showPassword.value = !showPassword.value;
};

// 12. Mendefinisikan form menggunakan useForm
const form = useForm({
  email: '',
  password: '',
  remember: false,
});

// 13. Membuat fungsi submit
const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'), // Kosongkan password setelah submit
  });
};
</script>

<style scoped>
/* Custom styles can be added here if needed */
</style>