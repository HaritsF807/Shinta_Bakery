<template>
  <div class="min-h-screen bg-amber-50">
    <!-- Navbar -->
    <Navbar />

    <!-- Main Content -->
    <div class="p-6 pt-32">

      <!-- Performance Cards (3 Kolom) -->
      <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Income This Month -->
        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <div class="bg-yellow-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
          </div>
          <div>
            <p class="text-xs text-gray-500">Income This Month</p>
            <p class="text-xl font-bold text-gray-800">Rp 4.000.000</p>
          </div>
        </div>

        <!-- Shipment This Month -->
        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <div class="bg-pink-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-pink-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17l6-6 6 6M2 12h20" />
            </svg>
          </div>
          <div>
            <p class="text-xs text-gray-500">Shipment This Month</p>
            <p class="text-xl font-bold text-gray-800">100 pcs</p>
          </div>
        </div>

        <!-- Shipment Pending -->
        <div class="bg-white rounded-xl shadow p-4 flex items-center">
          <div class="bg-yellow-100 p-3 rounded-full mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
          </div>
          <div>
            <p class="text-xs text-gray-500">Shipment Pending</p>
            <p class="text-xl font-bold text-gray-800">50</p>
          </div>
        </div>
      </div>

      <!-- Dua Kolom: Pending Orders & Rating & Review -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

        <!-- Kolom Kiri: Pending Orders Table -->
        <div class="bg-white rounded-xl shadow p-6">
          <h2 class="text-lg font-semibold text-gray-800 mb-4">Pending Orders (5)</h2>
          <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
              <thead>
                <tr>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ORDER ID</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">CUSTOMER</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">DATE</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">AMOUNT</th>
                  <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">STATUS</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="order in pendingOrders" :key="order.id" class="hover:bg-gray-50">
                  <td class="px-4 py-3 whitespace-nowrap text-sm font-medium text-gray-900">{{ order.id }}</td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ order.customer }}</td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ order.date }}</td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ order.amount }}</td>
                  <td class="px-4 py-3 whitespace-nowrap text-sm">
                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                      {{ order.status }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Kolom Kanan: Rating & Review -->
        <div class="bg-white rounded-xl shadow p-6">
          <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-800">Rating & Review</h2>
            <button class="text-gray-400 hover:text-gray-600">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0 2a2 2 0 100-4m-6 6h12" />
              </svg>
            </button>
          </div>
          <div class="space-y-3">
            <div v-for="(review, index) in reviews" :key="index" class="flex items-start gap-3">
              <img :src="review.image" :alt="Product" class="w-12 h-12 object-cover rounded-md" />
              <div class="flex-1">
                <div class="flex items-center mb-1">
                  <span class="text-yellow-500">★</span>
                  <span class="text-yellow-500">★</span>
                  <span class="text-yellow-500">★</span>
                  <span class="text-yellow-500">★</span>
                  <span class="text-yellow-500">★</span>
                  <span class="ml-2 text-xs text-gray-600">({{ review.rating }})</span>
                </div>
                <p class="text-sm text-gray-700">{{ review.comment }}</p>
              </div>
            </div>
          </div>
          <button class="mt-4 w-full py-2 bg-gray-100 text-gray-800 rounded-lg text-sm font-medium hover:bg-gray-200 transition">
            View All Messages
          </button>
        </div>
      </div>

      <!-- Best Seller -->
      <div class="mb-6">
        <h2 class="text-xl font-bold text-blue-600 mb-4">Best Seller</h2>
        <div class="flex space-x-4 overflow-x-auto pb-4">
          <div v-for="item in bestSellers" :key="item.name" class="bg-white rounded-xl shadow p-4 min-w-[200px] max-w-[220px]">
            <div class="relative">
              <img :src="item.image" :alt="item.name" class="w-full h-32 object-cover rounded-md" />
              <button class="absolute top-2 right-2 bg-red-100 text-red-600 p-1 rounded-full">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
              </button>
            </div>
            <h3 class="text-lg font-bold text-gray-800 mt-3">{{ item.name }}</h3>
            <div class="flex items-center mt-1">
              <span class="text-yellow-500">★</span>
              <span class="text-yellow-500">★</span>
              <span class="text-yellow-500">★</span>
              <span class="text-yellow-500">★</span>
              <span class="text-yellow-500">★</span>
              <span class="ml-1 text-xs text-gray-600">({{ item.rating }})</span>
            </div>
            <p class="text-pink-600 font-semibold mt-2">{{ item.price }}</p>
            <div class="mt-3 flex justify-between">
              <button 
                :class="[
                  'px-2 py-1 text-xs rounded-lg',
                  item.available ? 'bg-gray-200 text-gray-800' : 'bg-gray-400 text-gray-100 cursor-not-allowed'
                ]"
              >
                {{ item.available ? 'Habis' : 'Habis' }}
              </button>
              <button 
                class="px-2 py-1 bg-pink-600 text-white text-xs rounded-lg hover:bg-pink-700"
              >
                Detail
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import Navbar from "@/Components/NavbarAdmin.vue";
import { router } from '@inertiajs/vue3';

const logout = () => {
    router.post(route('logout'));
};

// Dummy data untuk pending orders
const pendingOrders = [
    {
        id: 'ORD-001',
        customer: 'Zaskia Nginx',
        date: '2025-11-18',
        amount: 'Rp 245.000',
        status: 'Pending'
    },
    {
        id: 'ORD-002',
        customer: 'Ani Wijaya',
        date: '2025-11-17',
        amount: 'Rp 189.500',
        status: 'Pending'
    },
    {
        id: 'ORD-003',
        customer: 'Rina Putri',
        date: '2025-11-16',
        amount: 'Rp 320.000',
        status: 'Pending'
    },
    {
        id: 'ORD-004',
        customer: 'Dedi Pratama',
        date: '2025-11-15',
        amount: 'Rp 150.750',
        status: 'Pending'
    },
    {
        id: 'ORD-005',
        customer: 'Siti Nurhaliza',
        date: '2025-11-14',
        amount: 'Rp 425.000',
        status: 'Pending'
    }
];

// Dummy data untuk rating & review
const reviews = [
  {
    image: "https://placehold.co/100x100/png?text=burger",
    rating: 5,
    comment: "Rotinya enak banget!"
  },
  {
    image: "https://placehold.co/100x100/png?text=tiramisu",
    rating: 5,
    comment: "Pelayanan cepat dan ramah."
  },
  {
    image: "https://placehold.co/100x100/png?text=burger",
    rating: 5,
    comment: "Harga agak mahal tapi rasa oke."
  },
  {
    image: "https://placehold.co/100x100/png?text=tiramisu",
    rating: 5,
    comment: "Roti cokelat favorit saya!"
  },
  {
    image: "https://placehold.co/100x100/png?text=burger",
    rating: 5,
    comment: "Suka sama roti keju disini."
  }
];

// Dummy data untuk best seller
const bestSellers = [
  {
    name: "Chicken Burger",
    price: "Rp 20.5k",
    rating: 5,
    available: true,
    image: "https://placehold.co/200x200/png?text=burger"
  },
  {
    name: "Tiramisu",
    price: "Rp 15k",
    rating: 5,
    available: true,
    image: "https://placehold.co/200x200/png?text=tiramisu"
  },
  {
    name: "Chicken Burger",
    price: "Rp 12.5k",
    rating: 5,
    available: true,
    image: "https://placehold.co/200x200/png?text=burger"
  },
  {
    name: "Tiramisu",
    price: "Rp 10k",
    rating: 5,
    available: true,
    image: "https://placehold.co/200x200/png?text=tiramisu"
  }
];
</script>