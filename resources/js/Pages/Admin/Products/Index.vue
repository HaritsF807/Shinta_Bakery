<script setup>
import { Head, router } from '@inertiajs/vue3'

defineProps({
  products: Array
})

// 🗑️ Fungsi hapus produk
function deleteProduct(id) {
  if (confirm('Yakin ingin menghapus produk ini?')) {
    router.delete(`/admin/products/${id}`)
  }
}
</script>

<template>
  <div class="p-6">
    <Head title="Daftar Produk" />

    <h1 class="text-2xl font-bold mb-4">Daftar Produk</h1>

    <table class="min-w-full border">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-2 border">ID</th>
          <th class="p-2 border">Gambar</th>
          <th class="p-2 border">Nama</th>
          <th class="p-2 border">Harga</th>
          <th class="p-2 border">Stok</th>
          <th class="p-2 border">Status</th>
          <th class="p-2 border text-center">Aksi</th>
        </tr>
      </thead>

      <tbody>
        <tr
          v-for="p in products"
          :key="p.id"
          class="hover:bg-gray-50 transition"
        >
          <td class="p-2 border">{{ p.id }}</td>

          <!-- 🖼️ Kolom gambar -->
          <td class="p-2 border text-center">
            <img
              v-if="p.image"
              :src="p.image.startsWith('storage') ? `/${p.image}` : `/storage/${p.image}`"
              alt="gambar produk"
              class="w-16 h-16 object-cover rounded mx-auto"
            />
            <span v-else class="text-gray-400 italic">tidak ada</span>
          </td>

          <td class="p-2 border">{{ p.name }}</td>
          <td class="p-2 border">Rp {{ p.price.toLocaleString('id-ID') }}</td>
          <td class="p-2 border">{{ p.stock }}</td>
          <td class="p-2 border">{{ p.status }}</td>

          <!-- 🔘 Tombol Aksi -->
          <td class="p-2 border text-center">
            <a
              :href="`/admin/products/${p.id}/edit`"
              class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
            >
              Edit
            </a>
            <a
              :href="`/admin/products/create`"
              class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition"
            >
              Tambah
            </a>
            <button
              @click="deleteProduct(p.id)"
              class="inline-block bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition ml-2"
            >
              Hapus
            </button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Pesan jika kosong -->
    <p v-if="products.length === 0" class="text-gray-500 mt-4">
      Belum ada produk tersedia.
    </p>
  </div>
</template>
