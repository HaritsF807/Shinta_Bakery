<template>
  <div class="font-sans bg-amber-50 text-gray-800">
    <!-- 🌸 Navbar -->
    <Navbar />

<!-- 🌸 Hero Section -->
<section
  class="bg-hero text-white w-full min-h-screen flex items-center px-4 sm:px-6 md:px-12 relative overflow-hidden">

  <div
    class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-6 md:gap-10 relative z-20">

    <!-- TEKS -->
    <div
      class="md:w-1/2 w-full text-center md:text-left pt-14 sm:pt-20 md:pt-0 px-2 pb-10 md:pb-0 fade-in relative z-30">

<h1
  class="text-3xl sm:text-4xl md:text-6xl font-bold mb-4 leading-tight drop-shadow-lg mt-10 md:mt-16"
>
  Special Offer This Month
</h1>

      <p class="text-sm sm:text-base md:text-lg opacity-90 mx-auto md:mx-0 max-w-md">
        We're here with the best desserts in town, made fresh with love and premium ingredients.
      </p>

      <Link
        href="/products"
        class="mt-6 inline-block bg-white text-pink-600 px-6 md:px-8 py-3 md:py-4 rounded-full font-semibold shadow hover:bg-pink-100 transition-all duration-300"
      >
        🍰 Buy Now
      </Link>
    </div>

    <!-- GAMBAR -->
    <div class="relative flex justify-center md:w-1/2 w-full fade-in z-10">

      <img 
        src="/images/LandingPage/cupcake-background.png"
        alt="Cupcake Hero"
        class="
          pointer-events-none object-contain select-none
          w-[78%] xs:w-[70%] sm:w-[65%] md:w-[75%] lg:w-[70%] xl:w-[60%]

          /* Jarak vertikal disesuaikan per layar */
          mt-6 sm:mt-10 md:mt-0 md:translate-y-10 lg:translate-y-16 xl:translate-y-20
        "
      />

    </div>

  </div>
</section>




    <!-- 🌸 Menu Section -->
    <section class="py-20 bg-amber-50 reveal">
      <div class="container mx-auto text-center">
        <h2 class="text-3xl font-bold text-pink-600 mb-12">Our Menu</h2>

        <div
          class="
            grid grid-cols-1 gap-8 px-4
            sm:grid-cols-2 
            md:grid-cols-4
            max-w-8xl mx-auto
          "
        >
          <div
            v-for="category in props.categories"
            :key="category.id"
            class="bg-white shadow-md rounded-xl p-6 border border-pink-100 reveal flex flex-col items-center text-center"
          >
            <!-- Ikon -->
            <div
              class="w-16 h-16 bg-pink-200 rounded-full flex items-center justify-center mb-4"
            >
              <svg
                v-if="category.name === 'Snack'"
                xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8 text-pink-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M16 11V7a4 4 0 00-8 0v4M12 13a4 4 0 100 8h4a4 4 0 004-4v-4a4 4 0 00-4-4h-4z"
                />
              </svg>

              <svg
                v-else-if="category.name === 'Food'"
                xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8 text-pink-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9M9 19c0 1.105-1.105 2-2.5 2S4 20.105 4 19V9C4 7.895 5.105 7 6.5 7S9 7.895 9 9v10zm6.5-3a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"
                />
              </svg>

              <svg
                v-else-if="category.name === 'Drinks'"
                xmlns="http://www.w3.org/2000/svg"
                class="h-8 w-8 text-pink-600"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M19 20H5a2 2 0 01-2-2v-7l3-4a2 2 0 012-1h10a2 2 0 012 1l3 4v7a2 2 0 01-2 2z"
                />
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M12 11v6m-6-6h12"
                />
              </svg>
            </div>

            <h3 class="text-lg font-semibold mb-2 text-pink-700">
              {{ category.name }}
            </h3>

            <p class="text-gray-600 text-sm mb-4">
              In the new era of technology we look in the future with certainty
              and pride for our life.
            </p>

            <Link
              :href="`/products?category=${category.id}`"
              class="text-pink-500 hover:underline font-medium text-xs"
            >
              Explore Menu →
            </Link>
          </div>
        </div>
      </div>
    </section>

    <!-- 🌸 Ready Section (WA restored) -->
    <section class="py-20 bg-white reveal">
      <div
        class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-10"
      >
        <div class="md:w-1/2 px-8">
          <h2 class="text-4xl font-bold text-pink-600 mb-4 leading-tight">
            Ready to Serve <br />
            Various Kinds of Food
          </h2>
          <p class="text-gray-700 mb-6 leading-relaxed">
We're ready to present a wide variety of delicious cakes, from classics to modern creations, made with love and the finest ingredients. Come explore our catalog and find your favorite cake to complete every special occasion!
          </p>

          <div class="flex gap-4">
            <!-- WA CONTACT US (RESTORED) -->
            <a
              href="https://wa.me/628113040033"
              target="_blank"
              class="px-6 py-3 bg-pink-600 text-white rounded-full font-semibold hover:bg-pink-700 transition"
            >
              Contact Us
            </a>

            <Link
              href="/products"
              class="px-6 py-3 border border-pink-600 text-pink-600 rounded-full hover:bg-pink-600 hover:text-white transition"
            >
              View Catalog
            </Link>
          </div>
        </div>

        <div class="md:w-1/2 flex justify-center">
          <img
            src="/images/LandingPage/group 19.png"
            class="w-80 sm:w-96 md:w-[480px]"
          />
        </div>
      </div>
    </section>

    <!-- 🌸 Our Story -->
    <section id="our-story" class="py-20 bg-pink-100 text-center reveal">
      <div class="container mx-auto max-w-3xl">
        <h2 class="text-3xl font-bold text-pink-700 mb-6">Our Story</h2>
        <p class="text-gray-700 leading-relaxed mb-8">
                Shinta Bakery started from a small home kitchen with a passion for creating delightful treats. Our founder, Shinta, believed in the magic of combining simple, high-quality ingredients with time-honored recipes. Today, we continue her legacy by sharing our love for baking with our community, one delicious snack at a time.
        </p>
      </div>

      <div class="mt-10 text-sm text-gray-600">
        © 2025 Shinta Bakery · Privacy Policy · Terms
      </div>
    </section>
  </div>
</template>

<script setup>
import Navbar from "../Components/Navbar.vue";
import { Link } from "@inertiajs/vue3";
import { defineProps, onMounted } from "vue";

const props = defineProps({
  categories: Array,
});

onMounted(() => {
  const elements = document.querySelectorAll(".reveal");

  const observer = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) entry.target.classList.add("visible");
    });
  });

  elements.forEach((el) => observer.observe(el));
});
</script>

<style scoped>
.bg-hero {
  background-image: url("/images/LandingPage/bg hero.png");
  background-size: cover;
  background-position: center;
}

/* Fade in */
.fade-in {
  opacity: 0;
  transform: translateY(30px);
  animation: fadeIn 1.4s ease-out forwards;
}

@keyframes fadeIn {
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Scroll reveal */
.reveal {
  opacity: 0;
  transform: translateY(40px);
  transition: all 1s ease;
}

.reveal.visible {
  opacity: 1;
  transform: translateY(0);
}
</style>
