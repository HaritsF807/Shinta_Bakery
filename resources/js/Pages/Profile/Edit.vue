<script setup>

import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'


defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const logout = () => {
    router.post(route('logout'), {}, {
        onSuccess: () => {
            window.location.href = '/';
        }
    });
};
</script>

<template>
    <Head title="Profile" />
    <div class="bg-amber-100">
        <AuthenticatedLayout>
            <template #header>
                <h2
                    class="text-xl font-semibold leading-tight text-gray-800"
                >
                    Profile
                </h2>
            </template>

            <div class="py-12">
                <div class="mx-auto max-w-7xl space-y-6 sm:px-6 lg:px-8">
                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <UpdateProfileInformationForm
                            :must-verify-email="mustVerifyEmail"
                            :status="status"
                            class="max-w-xl"
                        />
                    </div>

                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <UpdatePasswordForm class="max-w-xl" />
                    </div>

                    <div
                        class="bg-white p-4 shadow sm:rounded-lg sm:p-8"
                    >
                        <DeleteUserForm class="max-w-xl" />
                        <div class="mt-8 border-t pt-6 relative ">
                            <button
                                @click="logout"
                                type="button"
                                class="inline-flex items-center px-8 py-2 bg-red-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-800 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                            >
                                Logout
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    </div>
</template>
