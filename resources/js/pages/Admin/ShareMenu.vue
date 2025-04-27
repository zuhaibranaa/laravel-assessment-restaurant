<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
const { auth, restaurants, id } = defineProps(['auth', 'restaurants', 'id']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Menu',
        href: `/${auth.user.role}/menu`,
    },
    {
        title: 'Share',
        href: `/${auth.user.role}/menu/${id}/share`,
    },
];
const form = useForm({
    restaurant_ids: []
});

const submit = () => {
    form.post(`/${auth.user.role}/menu/${id}/share`, {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create Menu" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h2 class="mb-4 text-xl font-semibold">Add New Menu</h2>

            <form @submit.prevent="submit" class="space-y-4">

                <div>
                    <label class="mb-1 block font-medium">Restaurant</label>
                    <select v-model="form.restaurant_ids" type="text" class="w-full rounded border px-4 py-2" required multiple >
                        <option v-for="restaurant in restaurants" :value="restaurant.id">{{restaurant.name}}</option>
                    </select>
                    <div v-if="form.errors.restaurant_ids" class="text-sm text-red-500">{{ form.errors.restaurant_ids }}</div>
                </div>

                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" :disabled="form.processing">Create</button>
            </form>
        </div>
    </AppLayout>
</template>
