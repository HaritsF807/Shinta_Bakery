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
        <strong><a href="/" class="hover:underline">Home</a></strong>
        <strong><a href="#" class="hover:underline">Catalog</a></strong>
        <strong><a href="#" class="hover:underline">About Us</a></strong>
        <strong><a href="/login" class="hover:underline">Admin</a></strong>
        <strong><a href="/history" class="hover:underline">History</a></strong>
      </nav>

      <!-- Keranjang -->
      <div class="flex items-center relative">
        <button 
          class="ml-4 text-2xl hover:text-pink-200"
          @click="toggleSidebar"
        >
          <img src="/images/LandingPage/Shopping cart.png" alt="Keranjang">
        </button>

        <!-- Overlay + Sidebar -->
        <transition name="fade">
          <div 
            v-if="isSidebarOpen"
            class="fixed inset-0 bg-black bg-opacity-50 z-40"
            @click.self="toggleSidebar"
          >
            <transition name="slide">
              <SidebarKeranjang
                v-if="isSidebarOpen"
                @close="toggleSidebar"
                :cart-items="cartItems"
              />
            </transition>
          </div>
        </transition>
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
