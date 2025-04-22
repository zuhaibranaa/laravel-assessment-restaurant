<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
const { auth, restaurants } = defineProps(['auth', 'restaurants']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Menu',
        href: `/${auth.user.role}/menu`,
    },
    {
        title: 'Create',
        href: `/${auth.user.role}/menu/create`,
    },
];
const form = useForm({
    name: '',
    restaurant_id: ''
});

const submit = () => {
    form.post(`/${auth.user.role}/menu`, {
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
                    <label class="mb-1 block font-medium">Name</label>
                    <input v-model="form.name" type="text" class="w-full rounded border px-4 py-2" required />
                    <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                </div>


                <div>
                    <label class="mb-1 block font-medium">Restaurant</label>
                    <select v-model="form.restaurant_id" type="text" class="w-full rounded border px-4 py-2" required >
                        <option v-for="restaurant in restaurants" :value="restaurant.id">{{restaurant.name}}</option>
                    </select>
                    <div v-if="form.errors.restaurant_id" class="text-sm text-red-500">{{ form.errors.restaurant_id }}</div>
                </div>

                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" :disabled="form.processing">Create</button>
            </form>
        </div>
    </AppLayout>
</template>
