<template>
  <div class="font-sans">
    <!-- Header -->
    <div class="navbar">
      <Navbar />
    </div>

    <!-- Hero Section -->
    <section class="bg-hero text-white py-16 px-4 md:px-8 relative overflow-hidden">
      <div class="container mx-auto flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-8 md:mb-0"><br><br>
          <h2 class="text-6x3 md:text-4xl font-bold mb-4" style="font-size: 60px;line-height: 1.0;">Special Offer for March</h2>
          <p class="mb-6" style="width: 200px;">We are here with the best deserts intown.</p>
          <button class="bg-white text-pink-500 px-16 py-5 rounded-lg font-semibold hover:bg-pink-100 transition">
            <strong>Buy Now</strong>
          </button>
        </div>
        <div>
          <img src="/images/LandingPage/hero asset.png" alt="Burgers" class="burger" />
        </div>
      </div>
    </section>

    <!-- Our Menu Section -->
    <section class="py-16 bg-amber-50 px-4">
      <div class="container mx-auto">
        <h2 class="text-2xl font-bold text-pink-600 text-center mb-10">Our Menu</h2>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8 px-4 max-w-4xl mx-auto" style="position: relative; left: 120px;">
          <div v-for="item in menuItems" :key="item.title" class="bg-white p-6 rounded-lg shadow-md text-center">
            <div class="flex items-center justify-center">
              <img :src="item.icon" alt="Menu Icon" class="w-10 h-10 object-contain" />
            </div>
            <h3 class="text-xl font-semibold mb-2">{{ item.title }}</h3>
            <p class="text-sm text-gray-600 mb-4">{{ item.description }}</p>
            <button class="text-pink-600 text-sm font-medium hover:underline">Explore Menu</button>
          </div>
        </div>
      </div>
    </section>

    <!-- Ready to Serve Section -->
    <section class="py-16 bg-amber-50 px-4 py-8">
      <div class="container mx-auto flex flex-col md:flex-row items-center">
        <div class="md:w-1/2 mb-8 md:mb-0">
          <p class="text-4xl text-pink-600 mb-4" style="font-size: 50px; width: 650px;line-height: 1.0;">Ready to Serve Various Kinds of Food</p>
          <p class="text-sm text-gray-700 mb-6">
            We're ready to present a wide variety of delicious cakes, from classics to modern creations, made with love and the finest ingredients.
            Come explore our catalog and find your favorite cake to complete every special occasion!
          </p>
          <div class="flex space-x-4">
            <button class="bg-white border border-gray-300 text-gray-700 px-15 py-2 rounded-full text-sm hover:bg-gray-100"
              style="background-image: url('/images/LandingPage/bg-button.png'); background-size:cover; background-position: center;width: 100px;"
              onmouseover="this.style.backgroundColor='white'; this.style.backgroundImage='none'; this.style.color='black';"
              onmouseout="this.style.backgroundImage='url(/images/LandingPage/bg-button.png)'; this.style.backgroundColor=''; this.style.color='white';">
              <p style="width: 100px; position: relative; color: #000;"><strong>Contact Us</strong></p>
            </button>
            <button class="bg-pink-200 text-pink-700 px-15 py-2 rounded-full text-sm hover:bg-pink-300"
              style="background-image: url('/images/LandingPage/bg-button.png'); background-size:cover; background-position: center;width: 110px;"
              onmouseover="this.style.backgroundColor='white'; this.style.backgroundImage='none'; this.style.color='black';"
              onmouseout="this.style.backgroundImage='url(/images/LandingPage/bg-button.png)'; this.style.backgroundColor=''; this.style.color='white';">
              <p style="width: 100px; position: relative;left: 5px; color: black;"><strong>View Catalog</strong></p>
            </button>
          </div>
        </div>
        <div class="md:w-1/2 relative">
          <div class="relative w-full max-w-md mx-auto">
            <img src="/images/LandingPage/group 19.png" alt="Food 1">
          </div>
        </div>
      </div>
    </section>

    <!-- Our Story Section -->
    <section class="py-20 bg-pink-200 px-4">
      <div class="container mx-auto max-w-4xl">
        <h2 class="text-2xl font-bold text-center mb-6">Our Story</h2>
        <p class="text-sm text-gray-700 leading-relaxed mb-8 text-center">
          Shinta Bakery started from a small home kitchen with a passion for creating delightful treats. Our founder, Shinta, believed in the magic of combining simple, high-quality ingredients with time-honored recipes. Today, we continue her legacy by sharing our love for baking with our community, one delicious snack at a time.
        </p>
        <div class="flex justify-center space-x-4 mt-8">
          <a href="#" class="text-gray-500 hover:text-gray-700"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-gray-500 hover:text-gray-700"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-gray-500 hover:text-gray-700"><i class="fab fa-twitter"></i></a>
        </div>
      </div><br><br>
      <div class="mt-6 text-xs text-center text-gray-500" style="position: relative; top: 50px;">
        Kebijakan Privasi · Syarat & Ketentuan<br />
        © 2025 Shinta Bakery. All rights reserved.
      </div>
    </section>
  </div>
</template>

<script setup>
import Navbar from '../Components/Navbar.vue'
import { ref } from 'vue'

const menuItems = ref([
  {
    title: 'Snack',
    icon: '/images/LandingPage/snack logo.png',
    description: 'Delicious light bites to satisfy your cravings anytime, anywhere.'
  },
  {
    title: 'Food',
    icon: '/images/LandingPage/food logo.png',
    description: 'Tasty and freshly made meals prepared to fill your day with energy.'
  },
  {
    title: 'Drinks',
    icon: '/images/LandingPage/drink logo.png',
    description: 'Refreshing beverages to keep you cool and hydrated throughout the day.'
  }
])
</script>

<style scoped>
.bg-hero {
  background-image: url('/images/LandingPage/bg hero.png');
  background-size: cover;
  background-position: center;
}
.burger {
  position: relative;
  left: 100px;
  top: 70px;
}
.flex space-x-4:hover {
  background-color: antiquewhite;
  display: flex;
  gap: 1rem;
}
</style>
