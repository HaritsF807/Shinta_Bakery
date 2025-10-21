<script setup>
import { useForm } from '@inertiajs/vue3'

const form = useForm({ name: '' })

function submit() {
  form.post('/admin/categories')
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Tambah Kategori</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Nama Kategori</label>
        <input v-model="form.name" type="text" class="border p-2 w-full rounded" />
      </div>

      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Simpan
      </button>
    </form>
  </div>
</template>
