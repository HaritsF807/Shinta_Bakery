<template>
    <header class="bg-pink-500 text-white p-4 shadow-md">
      <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center space-x-2">
          <img src="/images/LandingPage/logo shinta.png" alt="Logo" class="rounded-full" />
          <h1 class="text-xl font-bold">Shinta Bakery</h1>
        </div>

        
        <nav class="hidden md:flex space-x-4">
          <strong><a href="/" class="hover:underline">Home</a></strong>
          <strong><a href="#" class="hover:underline">Catalog</a></strong>
          <strong><a href="#" class="hover:underline">About Us</a></strong>
          <strong><a href="#" class="hover:underline">Admin</a></strong>
          <strong><a href="/history" class="hover:underline">History</a></strong>
        </nav>
        

        <div class="flex items-center">
          <button class="ml-4 text-2xl hover:text-pink-200">
            <img src="/images/LandingPage/Shopping cart.png" alt="">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10v8a2 2 0 002 2H5a2 2 0 002-2v-8zm5-1a2 2 0 110-4 2 2 0 010 4z" />
            
          </button>
        </div>
      </div>
    </header>
</template>

<script>
import { Link } from '@inertiajs/vue3'
</script>

<style>
.rounded-full{
  height: 40px;
  width: 50px;
}
header{
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: #F93679;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
  z-index: 50;
}
</style>