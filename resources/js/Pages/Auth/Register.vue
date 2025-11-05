<script setup>
import { ref } from 'vue'

import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const showPassword1 = ref(false);
const showPassword2 = ref(false);

const togglePasswordVisibility = (field) => {
  if (field === 'password1') showPassword1.value = !showPassword1.value;
  else if (field === 'password2') showPassword2.value = !showPassword2.value;
};

const submit = () => {
  form.post(route('register'), {
    onFinish: () => form.reset('password', 'password_confirmation'),
  });
};
</script>

<template>
  <GuestLayout>
    <Head title="Register" />

    <div class="min-h-screen bg-[#FFF8E8] flex items-center justify-center p-6">
      <div class="w-full md:w-3/4 flex flex-col md:flex-row items-center gap-10 mt-16">
        <!-- Left side -->
        <div class="w-full md:w-1/3 flex flex-col items-start space-y-6">
          <h1 class="text-purple-700 text-2xl font-bold mb-8 absolute top-8">Shinta Bakery's Admin</h1>
          
        </div>

        <!-- Right side - Register Form -->
        <div class="w-full md:w-2/3 max-w-md relative right-8">
          <h2 class="text-4xl font-bold text-black mb-8 text-center">Sign Up</h2>

          <form @submit.prevent="submit" class="space-y-6">
            <!-- Name -->
            <div>
              <label for="name" class="block text-black font-semibold mb-2">Name</label>
              <input
                id="name"
                v-model="form.name"
                type="text"
                placeholder="Enter your name"
                class="w-full px-4 py-3 bg-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                required
              />
              <p v-if="form.errors.name" class="text-red-600 text-sm mt-1">{{ form.errors.name }}</p>
            </div>

            <!-- Email -->
            <div>
              <label for="email" class="block text-black font-semibold mb-2">Email</label>
              <input
                id="email"
                v-model="form.email"
                type="email"
                placeholder="Enter your email"
                class="w-full px-4 py-3 bg-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                required
              />
              <p v-if="form.errors.email" class="text-red-600 text-sm mt-1">{{ form.errors.email }}</p>
            </div>

            <!-- Password -->
            <div class="relative">
              <label for="password" class="block text-black font-semibold mb-2">Password</label>
              <input
                :type="showPassword1 ? 'text' : 'password'"
                id="password"
                v-model="form.password"
                placeholder="Enter your password"
                class="w-full px-4 py-3 bg-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                required
              />
              <button
                type="button"
                @click="togglePasswordVisibility('password1')"
                class="absolute right-3 top-10 text-black"
              >
                <svg v-if="showPassword1" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 012.557-5.37c1.264-1.584 3.164-2.87 5.414-3.36a10.05 10.05 0 0110.05 10.05 9.97 9.97 0 01-3.36 5.414c-1.584 1.264-3.87 2.264-5.37 2.557z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
              <p v-if="form.errors.password" class="text-red-600 text-sm mt-1">{{ form.errors.password }}</p>
            </div>

            <!-- Confirm Password -->
            <div class="relative">
              <label for="password_confirmation" class="block text-black font-semibold mb-2">Confirm Password</label>
              <input
                :type="showPassword2 ? 'text' : 'password'"
                id="password_confirmation"
                v-model="form.password_confirmation"
                placeholder="Confirm your password"
                class="w-full px-4 py-3 bg-pink-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-pink-500"
                required
              />
              <button
                type="button"
                @click="togglePasswordVisibility('password2')"
                class="absolute right-3 top-10 text-black"
              >
                <svg v-if="showPassword2" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 012.557-5.37c1.264-1.584 3.164-2.87 5.414-3.36a10.05 10.05 0 0110.05 10.05 9.97 9.97 0 01-3.36 5.414c-1.584 1.264-3.87 2.264-5.37 2.557z" />
                </svg>
                <svg v-else xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                  viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
              </button>
              <p v-if="form.errors.password_confirmation" class="text-red-600 text-sm mt-1">
                {{ form.errors.password_confirmation }}
              </p>
            </div>

            <!-- Submit -->
            <div class="pt-4">
              <button
                type="submit"
                :disabled="form.processing"
                class="w-full bg-red-600 text-white font-semibold py-3 px-4 rounded-lg hover:bg-red-700 transition-colors disabled:opacity-50"
              >
                {{ form.processing ? 'Registering...' : 'Sign Up' }}
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
