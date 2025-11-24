<template>
  <div class="font-sans bg-amber-50 text-gray-800">
    <!-- 🌸 Navbar -->
    <Navbar />

    <!-- 🌸 Hero Section -->
    <section
      class="bg-hero text-white  py-20 px-6 md:px-12 relative overflow-hidden"
    >
      <div
        class="container mb-4 mx-auto flex flex-col md:flex-row items-center justify-between"
      >
        <div class="md:w-1/2 mt-4 md:mb-4 relative top-12">
          <h1
            class="text-4xl md:text-6xl font-bold mb-4 leading-tight drop-shadow-lg"
          >
            Special Offer This Month
          </h1>
          <p class="mb-8 text-lg opacity-90 max-w-md">
            We’re here with the best desserts in town, made fresh with love and
            premium ingredients.
          </p>
          <Link
            href="/products"
            class="bg-white text-pink-600 px-8 py-4 rounded-full font-semibold shadow hover:bg-pink-100 transition-all duration-300"
          >
            🍰 Buy Now
          </Link>
        </div>

        <div class="md:w-1/2 flex justify-center  ">
          <img
            src="/images/LandingPage/hero asset.png"
            alt="Cakes"
            class="w-240 md:w-[720px] relative top-32 left-12"
          />
        </div>
      </div>
    </section>

    <!-- 🌸 Menu Section -->
    <section class="py-20 bg-amber-50">
      <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold text-pink-600 mb-12">Our Menu</h2>

        <div
          class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10 max-w-5xl mx-auto"
        >
          <div
           v-for="category in props.categories" 
          :key="category.id"
          class="bg-white shadow-md rounded-xl p-4 border border-pink-200">
            
            <h3 class="text-xl font-semibold mb-2 text-pink-700">
              {{ category.name }}
            </h3>
            
            <Link
              :href="`/products?category=${category.id}`"
              class="text-pink-600 hover:underline font-medium text-sm"
            >
              Explore Menu →
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- 🌸 Ready to Serve Section -->
    <section class="py-20 bg-white">
      <div
        class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-10"
      >
        <div class="md:w-1/2 px-8">
          <h2 class="text-4xl font-bold text-pink-600 mb-4 leading-tight">
            Ready to Serve <br />
            Various Kinds of Food
          </h2>
          <p class="text-gray-700 mb-6 leading-relaxed">
            We’re ready to present a wide variety of delicious cakes — from
            timeless classics to modern creations — crafted with love and the
            finest ingredients. Explore our catalog and find your favorite treat
            for every occasion!
          </p>
          <div class="flex gap-4">
            <a
              href="https://wa.me/628113040033" target="_blank"
              class="px-6 py-3 bg-pink-600 text-white rounded-full font-semibold hover:bg-pink-700 transition"
              >Contact Us</a>
            <a
              href="/products" 
              class="px-6 py-3 border border-pink-600 text-pink-600 rounded-full font-semibold hover:bg-pink-600 hover:text-white transition"
              >View Catalog</a>
          </div>
        </div>

        <div class="md:w-1/2 flex justify-center">
          <img
            src="/images/LandingPage/group 19.png"
            alt="Bakery items"
            class="w-96 md:w-[480px]"
          />
        </div>
      </div>
    </section>

    <!-- 🌸 Our Story -->
    <section id="our-story"class="py-20 bg-pink-100 text-center">
      <div class="container mx-auto max-w-3xl">
        <h2 class="text-3xl font-bold text-pink-700 mb-6">Our Story</h2>
        <p class="text-gray-700 leading-relaxed mb-8">
          Shinta Bakery started from a small home kitchen with a passion for
          creating delightful treats. Our founder, Shinta, believed in the magic
          of high-quality ingredients and timeless recipes. Today, we continue
          her legacy — sharing sweetness and smiles, one bite at a time.
        </p>

        <div class="flex justify-center space-x-6 text-pink-700 text-2xl">
          <a href="#" class="hover:text-pink-500"
            ><i class="fab fa-instagram"></i
          ></a>
          <a href="#" class="hover:text-pink-500"
            ><i class="fab fa-facebook"></i
          ></a>
          <a href="#" class="hover:text-pink-500"
            ><i class="fab fa-twitter"></i
          ></a>
        </div>
      </div>

      <div class="mt-10 text-sm text-gray-600">
        <p>© 2025 Shinta Bakery · Privacy Policy · Terms & Conditions</p>
      </div>
    </section>
  </div>
</template>

<script setup>
import SideBarKeranjang from '@/Components/SideBarKeranjang.vue'
import Navbar from "../Components/Navbar.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import { defineProps } from 'vue'

const props = defineProps({
  categories: Array
})
const cartOpen = ref(false)
const toggleCart = () => (cartOpen.value = !cartOpen.value)

</script>

<style scoped>
.bg-hero {
  background-image: url("/images/LandingPage/bg hero.png");
  background-size: cover;
  background-position: center;
}

/* 🩷 Floating animation for hero image */
@keyframes float {
  0%,
  100% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-10px);
  }
}
.animate-float {
  animation: float 4s ease-in-out infinite;
}
</style>
