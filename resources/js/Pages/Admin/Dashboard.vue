<script setup>
import { router } from '@inertiajs/vue3';

const logout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="p-6 text-gray-900">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <p>Selamat datang, Admin!</p>
        
        <button
            @click="logout"
            class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition"
        >
            Logout
        </button>
    </div>
</template>