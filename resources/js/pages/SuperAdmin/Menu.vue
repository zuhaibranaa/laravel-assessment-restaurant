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
                    <h2 class="text-xl font-semibold">Menus</h2>
                    <Link :href="`/${auth.user.role}/menu/create`" class="inline-block rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
                        + Add Menu
                    </Link>
                </div>
                <table id="restaurant-table" class="display w-full text-left">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Restaurant</th>
                            <th>Using Shared</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="h-10" v-for="menu in menus" :key="menu.id">
                            <td>{{ menu.id }}</td>
                            <td>{{ menu.name }}</td>
                            <td>{{ menu.restaurant.name }}</td>
                            <td>{{ menu.restaurant.useSharedMenu ? 'True': 'False' }}</td>
                            <td>
                                <Link :href="`/${auth.user.role}/menu/${menu.id}/view`" class="rounded bg-blue-800 p-2 mx-1 my-2 size-0.5 text-xs text-white"> View </Link>
                                <Link :href="`/${auth.user.role}/menu/${menu.id}/add`" class="rounded bg-green-800 p-2 mx-1 my-2 size-0.5 text-xs text-white"> Add Menu Item </Link>
                                <Link :href="`/${auth.user.role}/menu/${menu.id}/share`" class="rounded bg-indigo-800 p-2 mx-1 my-2 size-0.5 text-xs text-white"> Share </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
