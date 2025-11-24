<template>
  <header class="bg-pink-500 text-white p-4 shadow-md h-24">
    <div class="container mx-auto flex justify-between items-center relative bottom-2">
      
      <!-- Logo -->
      <div class="flex items-center space-x-2 relative left-8">
        <img src="/images/LandingPage/logo shinta.png" alt="Logo" class="w-24" />
        <h1 class="text-2xl font-bold">Shinta Bakery</h1>
      </div>

      <!-- Navigation -->
      <nav class="hidden md:flex space-x-6 text-xl">

        <strong><a href="/" class="hover:underline">Home</a></strong>
        <strong><a href="/products" class="hover:underline">Products</a></strong>
        <strong><a href="/history" class="hover:underline">History</a></strong>
        <strong>
          <a href="/#our-story" class="hover:underline" style="scroll-behavior: smooth;">
            About Us
          </a>
        </strong>

        <!-- ⭐ Download PDF -->
        <strong>
          <a 
            href="/katalog/katalog_shinta.pdf"
            download
            class="bg-white text-pink-600 px-3 py-1 rounded-md hover:bg-pink-200 transition"
          >
            Download PDF
          </a>
        </strong>

      </nav>

      <!-- Keranjang -->
      <div class="flex items-center relative right-24">
        <button class="ml-4 text-2xl hover:text-pink-200">
          <a href="/cart">
            <img src="/images/LandingPage/Shopping cart.png" alt="Keranjang" class="relative left-16">
          </a>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref } from 'vue'
import SidebarKeranjang from '@/Components/SidebarKeranjang.vue'

const isSidebarOpen = ref(false)

const cartItems = ref([
  { name: 'Roti Coklat', price: 15000, quantity: 1 },
  { name: 'Donat Keju', price: 12000, quantity: 2 },
])

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}
</script>

<style scoped>
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.slide-enter-active, .slide-leave-active {
  transition: transform 0.3s ease;
}
.slide-enter-from, .slide-leave-to {
  transform: translateX(100%);
}

.rounded-full {
  height: 40px;
  width: 50px;
}

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
