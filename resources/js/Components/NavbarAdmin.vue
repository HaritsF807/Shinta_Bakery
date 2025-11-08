<template>
  <header class="bg-pink-500 text-white p-4 shadow-md">
    <div class="container mx-auto flex justify-between items-center">
      <!-- Logo -->
      <div class="flex items-center space-x-2">
        <img src="/images/LandingPage/logo shinta.png" alt="Logo" class="rounded-full" />
        <h1 class="text-xl font-bold">Shinta Bakery</h1>
      </div>

      <!-- Navigation -->
      <nav class="hidden md:flex space-x-4">
        <strong><a href="/admin/dashboard" class="hover:underline">Dashboard</a></strong>
        <strong><a href="/admin/products" class="hover:underline">Products</a></strong>
        <strong><a href="/admin/categories" class="hover:underline">Categories</a></strong>
        <strong><a href="/admin/orders" class="hover:underline">Orders</a></strong>
      </nav>

      <!-- Keranjang -->
      <div class="flex items-center relative">
      <button class="ml-4 text-2xl hover:text-pink-200">
        <a href="/admin/profile">
          <img src="/images/account_circle.png" alt="Keranjang">
        </a>
      </button>

        <!-- Overlay + Sidebar -->
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import SidebarKeranjang from '@/Components/SidebarKeranjang.vue'

// State
const isSidebarOpen = ref(false)

// contoh data keranjang (sementara, biar kelihatan)
const cartItems = ref([
  { name: 'Roti Coklat', price: 15000, quantity: 1 },
  { name: 'Donat Keju', price: 12000, quantity: 2 },
])

// Fungsi toggle
const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}
</script>

<style scoped>
/* Fade background */
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

/* Slide sidebar */
.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from, .slide-leave-to {
  transform: translateX(100%);
}

/* Logo */
.rounded-full {
  height: 40px;
  width: 50px;
}

/* Header */
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background-color: #F93679;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
  z-index: 50;
}
</style>
