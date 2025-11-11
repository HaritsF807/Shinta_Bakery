<script setup>
import Navbar from "@/Components/NavbarAdmin.vue";
import { Head, router } from "@inertiajs/vue3";

defineProps({
  categories: Array,
});

function deleteCategory(id) {
  if (confirm("Yakin ingin menghapus kategori ini?")) {
    router.delete(`/admin/categories/${id}`);
  }
}
</script>

<template>
  <Navbar />

  <div class="min-h-screen bg-amber-100 p-6 flex justify-center items-center relative top-16">
    <Head title="Daftar Kategori" />

    <div class="bg-pink-500 rounded-xl shadow-lg w-full max-w-5xl p-6">
      

      <!-- Tombol Tambah -->
      <div class="flex justify-center mb-6">
        <h1 class="text-2xl font-bold text-white px-80 relative right-80">Daftar Kategori</h1>
        <a
          href="/admin/categories/create"
          class="bg-white text-black px-4 py-2 rounded-full font-medium hover:bg-gray-100 transition-colors"
        >
          + Tambah Kategori
        </a>
      </div>

      <!-- Tabel Kategori -->
      <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama</th>
              <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase text-center">Aksi</th>
            </tr>
          </thead>

          <tbody class="divide-y divide-gray-200">
            <tr
              v-for="c in categories"
              :key="c.id"
              :class="c.id % 2 === 0 ? 'bg-gray-50' : 'bg-white'"
              class="hover:bg-gray-100 transition"
            >
              <td class="px-6 py-4 text-sm text-gray-700">{{ c.id }}</td>
              <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ c.name }}</td>
              <td class="px-6 py-4 text-center">
                <a
                  :href="`/admin/categories/${c.id}/edit`"
                  class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-full text-sm font-medium transition"
                >
                  Edit
                </a>
                <button
                  @click="deleteCategory(c.id)"
                  class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-full text-sm font-medium transition ml-2"
                >
                  Hapus
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <p
        v-if="categories.length === 0"
        class="text-gray-200 mt-6 italic text-center"
      >
        Belum ada kategori tersedia.
      </p>
    </div>
  </div>
</template>
