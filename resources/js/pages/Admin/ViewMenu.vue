<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
const { auth, menu } = defineProps(['menu', 'auth']);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Menu',
        href: `/${auth.user.role}/menu`,
    },
];
</script>

<template>
    <Head title="Menu" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h1 class="text-2xl font-bold">Menu: {{ menu.name }}</h1>
                    <span class="text-gray-500">Restaurant: {{ menu.restaurant.name }}</span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div
                        v-for="item in menu.items"
                        :key="item.id"
                        class="bg-white rounded-xl shadow-md overflow-hidden border dark:bg-gray-800 dark:border-gray-700"
                    >
                        <img
                            v-if="item.image"
                            :src="`/storage/${item.image}`"
                            alt="Item image"
                            class="w-full h-48 object-cover"
                        />
                        <div class="p-4">
                            <h2 class="text-lg font-semibold">{{ item.item_name }}</h2>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Price: ${{ item.price }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
