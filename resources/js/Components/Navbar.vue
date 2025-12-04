<template>
  <header class="bg-[#F93679] text-white fixed top-0 left-0 w-full shadow-lg z-50">
    <div class="container mx-auto h-20 px-4 sm:px-6 flex items-center justify-between">

      <!-- Logo -->
      <div class="flex items-center gap-2 sm:gap-3">
        <img 
          src="/images/LandingPage/logo shinta.png" 
          alt="Logo" 
          class="w-12 xs:w-14 sm:w-20 transition-all duration-200" 
        />
        <h1 class="text-base xs:text-lg sm:text-xl font-bold whitespace-nowrap">
          Shinta Bakery
        </h1>
      </div>

      <!-- HAMBURGER MOBILE -->
      <button 
        @click="menuOpen = !menuOpen" 
        class="md:hidden text-3xl hover:text-pink-200 transition active:scale-95"
      >
        ☰
      </button>

      <!-- NAV DESKTOP -->
      <nav class="hidden md:flex space-x-8 text-base font-semibold absolute inset-x-0 mx-auto w-fit">
        <a href="/" class="hover:text-pink-200 transition">Home</a>
        <a href="/products" class="hover:text-pink-200 transition">Catalog</a>
        <a href="/history" class="hover:text-pink-200 transition">History</a>
      </nav>

      <!-- IKON PRINT + CART (DESKTOP) -->
      <div class="hidden md:flex items-center gap-6">
        
        <!-- Download Catalog -->
        <a 
          :href="catalogUrl"
          download
          class="nav-icon hover:text-pink-200 transition-all duration-300"
          title="Download Catalog PDF"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
          </svg>
        </a>

        <!-- Cart -->
        <a 
          href="/cart"
          class="nav-icon hover:text-pink-200 transition-all duration-300"
          title="View Cart"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </a>
      </div>
    </div>

    <!-- MENU MOBILE -->
    <transition name="fade">
      <nav 
        v-if="menuOpen" 
        class="md:hidden bg-[#FF4F8B] py-5 text-center space-y-5 font-semibold text-lg shadow-inner max-h-[300px] overflow-y-auto"
      >
        <a href="/" class="block hover:text-pink-200 transition">Home</a>
        <a href="/products" class="block hover:text-pink-200 transition">Catalog</a>
        <a href="/history" class="block hover:text-pink-200 transition">History</a>

        <!-- Cart Mobile -->
        <a href="/cart" class="flex justify-center items-center gap-3 hover:text-pink-200 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.66-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          Cart
        </a>

        <!-- Download Catalog Mobile -->
        <a 
          :href="catalogUrl"
          download
          class="flex justify-center items-center gap-3 hover:text-pink-200 transition"
        >
          <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
          </svg>
          Download Catalog
        </a>
      </nav>
    </transition>
  </header>
</template>


<script setup>
import { ref, onMounted } from 'vue'
import axios from 'axios'
import SidebarKeranjang from '@/Components/SidebarKeranjang.vue'

const menuOpen = ref(false);
const catalogUrl = ref('/katalog/katalog_shinta.pdf');

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
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

.nav-icon {
  display: inline-block;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
}
.nav-icon:hover {
  transform: translateY(-2px) scale(1.1);
  filter: drop-shadow(0 4px 8px rgba(255, 255, 255, 0.3));
}

/* HP kecil */
@media (max-width: 360px) {
  h1 {
    font-size: 0.9rem !important;
  }
}
</style>


