<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link, useForm } from '@inertiajs/vue3';

const { auth, restaurants } = defineProps(['restaurants', 'auth']);
const form = useForm({
    id: null
});

const submit = () => {
    form.post(`/${auth.user.role}/sharedToggle`, {
        onSuccess: () => {
            form.reset();
        },
    });
};
const handleUseSharedMenuToggle = (e: Event) => {
    e.preventDefault();
    form.id = e.target?.value;
    submit()
}
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
                    <Link
                        :href="`/${auth.user.role}/restaurant/create`"
                        class="inline-block rounded bg-green-600 px-4 py-2 text-white hover:bg-green-700"
                    >
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
                            <th>Menu</th>
                            <th>Shared Menu</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="h-10" v-for="restaurant in restaurants" :key="restaurant.id">
                            <td>{{ restaurant.id }}</td>
                            <td>{{ restaurant.name }}</td>
                            <td>{{ restaurant.location }}</td>
                            <td>{{ restaurant?.owner.name }}</td>
                            <td>{{ restaurant.active_menu?.name ?? '—' }}</td>
                            <td>
                                <label class="relative inline-flex cursor-pointer items-center">
                                    <input type="checkbox" @change="handleUseSharedMenuToggle" :value="restaurant.id" :checked="restaurant.useSharedMenu" class="peer sr-only" />

                                    <!-- Track (Background) -->
                                    <div
                                        class="h-6 w-11 rounded-full bg-gray-300 transition-colors peer-checked:bg-blue-600 peer-focus:ring-2 peer-focus:ring-blue-500"
                                    ></div>

                                    <!-- Thumb (Circle) -->
                                    <div
                                        class="absolute top-1 left-1 h-4 w-4 rounded-full bg-white transition-transform peer-checked:translate-x-5"
                                    ></div>
                                </label>
                            </td>
                            <td>
                                <Link
                                    :href="`/${auth.user.role}/menu/${restaurant.active_menu?.id}/view`"
                                    class="mx-1 my-2 size-0.5 rounded bg-blue-800 p-2 text-xs text-white"
                                >
                                    View
                                </Link>
                                <Link
                                    :href="`/${auth.user.role}/menu/${restaurant.active_menu.id}/add`"
                                    class="mx-1 my-2 size-0.5 rounded bg-green-800 p-2 text-xs text-white"
                                >
                                    Add Menu Item
                                </Link>
                                <Link
                                    :href="`/${auth.user.role}/menu/${restaurant.active_menu.id}/share`"
                                    class="mx-1 my-2 size-0.5 rounded bg-indigo-800 p-2 text-xs text-white"
                                >
                                    Share
                                </Link>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AppLayout>
</template>
