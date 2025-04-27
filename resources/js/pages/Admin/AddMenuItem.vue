<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import type { BreadcrumbItem } from '@/types';
const { auth, id } = defineProps(['auth', 'id']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Menu',
        href: `/${auth.user.role}/menu`,
    },
    {
        title: 'Add Menu Item',
        href: `/${auth.user.role}/menu/create`,
    },
];
const form = useForm({
    item_name: '',
    price: 0,
    image: ''
});

const setImage = (e: Event) => {
    form.image = e.target?.files[0];
}

const submit = () => {
    form.post(`/${auth.user.role}/menu/${id}/add`, {
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
                    <input v-model="form.item_name" type="text" class="w-full rounded border px-4 py-2" required />
                    <div v-if="form.errors.item_name" class="text-sm text-red-500">{{ form.errors.item_name }}</div>
                </div>

                <div>
                    <label class="mb-1 block font-medium">Price</label>
                    <input v-model="form.price" type="number" min="0" class="w-full rounded border px-4 py-2" required />
                    <div v-if="form.errors.price" class="text-sm text-red-500">{{ form.errors.price }}</div>
                </div>


                <div>
                    <label class="mb-1 block font-medium">Image</label>
                    <input type="file" @change="setImage"/>
                    <div v-if="form.errors.image" class="text-sm text-red-500">{{ form.errors.image }}</div>
                </div>

                <button type="submit" class="rounded bg-blue-600 px-4 py-2 text-white hover:bg-blue-700" :disabled="form.processing">Create</button>
            </form>
        </div>
    </AppLayout>
</template>
