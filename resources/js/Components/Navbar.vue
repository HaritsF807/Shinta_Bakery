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

      </nav>

      <!-- Icons: Print & Cart -->
      <div class="flex items-center gap-8">
        <!-- Print/Download PDF Icon -->
        <a 
          :href="catalogUrl"
          download
          class="nav-icon text-white hover:text-pink-200 transition-all duration-300"
          title="Download Catalog PDF"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            class="h-9 w-9" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor" 
            stroke-width="2"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
          </svg>
        </a>

        <!-- Cart Icon -->
        <a 
          href="/cart" 
          class="nav-icon text-white hover:text-pink-200 transition-all duration-300"
          title="View Cart"
        >
          <svg 
            xmlns="http://www.w3.org/2000/svg" 
            class="h-9 w-9" 
            fill="none" 
            viewBox="0 0 24 24" 
            stroke="currentColor" 
            stroke-width="2"
          >
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
          </svg>
        </a>
      </div>
    </div>
  </header>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import SidebarKeranjang from '@/Components/SidebarKeranjang.vue'

const isSidebarOpen = ref(false)
const catalogUrl = ref('/katalog/katalog_shinta.pdf'); // Default fallback

const cartItems = ref([
  { name: 'Roti Coklat', price: 15000, quantity: 1 },
  { name: 'Donat Keju', price: 12000, quantity: 2 },
])

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value
}

onMounted(async () => {
  try {
    const response = await axios.get('/api/catalog-path');
    if (response.data.success && response.data.url) {
      catalogUrl.value = response.data.url;
    }
  } catch (error) {
    console.error('Failed to fetch catalog path:', error);
  }
});
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

/* Nav Icon Hover Effect */
.nav-icon {
  display: inline-block;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-icon:hover {
  transform: translateY(-2px) scale(1.1);
  filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
}
</style>

