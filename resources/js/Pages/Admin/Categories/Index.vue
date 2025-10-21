<script setup>
import { router } from '@inertiajs/vue3'

defineProps({ categories: Array })

function deleteCategory(id) {
  if (confirm('Yakin ingin menghapus kategori ini?')) {
    router.delete(`/admin/categories/${id}`)
  }
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Kategori</h1>

    <a href="/admin/categories/create"
       class="bg-green-600 text-white px-4 py-2 rounded mb-4 inline-block hover:bg-green-700">
      + Tambah Kategori
    </a>

    <table class="min-w-full border">
      <thead>
        <tr class="bg-gray-100 text-left">
          <th class="p-2 border">ID</th>
          <th class="p-2 border">Nama</th>
          <th class="p-2 border text-center">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="c in categories" :key="c.id" class="hover:bg-gray-50">
          <td class="p-2 border">{{ c.id }}</td>
          <td class="p-2 border">{{ c.name }}</td>
          <td class="p-2 border text-center space-x-2">
            <a :href="`/admin/categories/${c.id}/edit`"
               class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">Edit</a>
            <button @click="deleteCategory(c.id)"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Hapus</button>
          </td>
        </tr>
      </tbody>
    </table>

    <p v-if="categories.length === 0" class="text-gray-500 mt-4">
      Belum ada kategori tersedia.
    </p>
  </div>
</template>
