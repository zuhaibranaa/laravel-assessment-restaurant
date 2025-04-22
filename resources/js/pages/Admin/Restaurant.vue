<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

const { restaurants, auth } = defineProps(['restaurants', 'auth']);
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Restaurant',
        href: `/${auth.user.role}/restaurant`,
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="border-sidebar-border/70 dark:border-sidebar-border relative min-h-[100vh] flex-1 rounded-xl border md:min-h-min">
                <pre>{{ restaurants }}</pre>
            </div>
        </div>
    </AppLayout>
</template>
