<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
const { auth, menus } = defineProps(['menus', 'auth']);
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
            <div class="rounded-xl border bg-white p-4 dark:bg-gray-900">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Restaurant List</h2>
                    <Link :href="`/${auth.user.role}/menu/create`" class="inline-block rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                        + Add Restaurant
                    </Link>
                </div>
                <table id="restaurant-table" class="display w-full text-left">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Location</th>
                            <th>Owner</th>
                            <th>Shared Menu</th>
                            <th>Menu</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="menu in menus" :key="menu.id">
                            <td>{{ menu.id }}</td>
                            <td>{{ menu.name }}</td>
                            <td>
                                <Link :href="`/admin/restaurants/${menu.id}`" class="text-blue-600 hover:underline"> View </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
