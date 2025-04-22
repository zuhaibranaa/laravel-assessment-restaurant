<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
const { auth, users } = defineProps(['auth', 'users']);

const form = useForm({
    name: '',
    location: '',
    owner_id: ''
});
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Restaurant',
        href: `/${auth.user.role}/restaurant`,
    },
    {
        title: 'Create',
        href: `/${auth.user.role}/restaurant/create`,
    },
];

const submit = () => {
    form.post(`/${auth.user.role}/restaurant`, {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head title="Create Restaurant" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <h2 class="mb-4 text-xl font-semibold">Add New Restaurant</h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="mb-1 block font-medium">Name</label>
                    <input v-model="form.name" type="text" class="w-full rounded border px-4 py-2" required />
                    <div v-if="form.errors.name" class="text-sm text-red-500">{{ form.errors.name }}</div>
                </div>

                <div>
                    <label class="mb-1 block font-medium">Location</label>
                    <input v-model="form.location" type="text" class="w-full rounded border px-4 py-2" required />
                    <div v-if="form.errors.location" class="text-sm text-red-500">{{ form.errors.location }}</div>
                </div>

                <div>
                    <label class="mb-1 block font-medium">Owner</label>
                    <select v-model="form.owner_id" type="text" class="w-full rounded border px-4 py-2" required >
                        <option v-for="user in users" :value="user.id">{{user.name}}</option>
                    </select>
                    <div v-if="form.errors.owner_id" class="text-sm text-red-500">{{ form.errors.owner_id }}</div>
                </div>

                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" :disabled="form.processing">Create</button>
            </form>
        </div>
    </AppLayout>
</template>
