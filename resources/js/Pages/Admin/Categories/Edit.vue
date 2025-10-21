<script setup>
import { useForm } from '@inertiajs/vue3'

const props = defineProps({ category: Object })

const form = useForm({ name: props.category.name })

function submit() {
  form.put(`/admin/categories/${props.category.id}`)
}
</script>

<template>
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Kategori</h1>

    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label class="block font-semibold mb-1">Nama Kategori</label>
        <input v-model="form.name" type="text" class="border p-2 w-full rounded" />
      </div>

      <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        Simpan Perubahan
      </button>
    </form>
  </div>
</template>
