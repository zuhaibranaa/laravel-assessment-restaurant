<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
const { auth, restaurants } = defineProps(['restaurants', 'auth']);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Restaurant',
        href: `/${auth.user.role}/restaurant`,
    },
];
</script>

<template>
    <Head title="Restaurants" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl border bg-white p-4 dark:bg-gray-900">
                <div class="mb-4 flex items-center justify-between">
                    <h2 class="text-xl font-semibold">Restaurant List</h2>
                    <Link :href="`/${auth.user.role}/restaurant/create`" class="inline-block rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700">
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
                        <tr v-for="restaurant in restaurants" :key="restaurant.id">
                            <td>{{ restaurant.id }}</td>
                            <td>{{ restaurant.name }}</td>
                            <td>{{ restaurant.location }}</td>
                            <td>{{ restaurant.owner.name }}</td>
                            <td>{{ restaurant.useSharedMenu ? 'True': 'False' }}</td>
                            <td v-if="restaurant.useSharedMenu">{{ restaurant.sharedMenu?.name ?? '—' }}</td>
                            <td v-else>{{ restaurant.menu?.name ?? '—' }}</td>
                            <td>
                                <Link :href="`/admin/restaurants/${restaurant.id}`" class="text-blue-600 hover:underline"> View </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
