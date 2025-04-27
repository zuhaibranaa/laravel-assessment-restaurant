<script setup lang="ts">
import NavFooter from '@/components/NavFooter.vue';
import NavMain from '@/components/NavMain.vue';
import NavUser from '@/components/NavUser.vue';
import { Sidebar, SidebarContent, SidebarFooter, SidebarHeader, SidebarMenu, SidebarMenuButton, SidebarMenuItem } from '@/components/ui/sidebar';
import { type NavItem } from '@/types';
import { Page } from '@inertiajs/core';
import { Link, usePage } from '@inertiajs/vue3';
import { BookOpen, HandPlatter, LayoutGrid } from 'lucide-vue-next';
import AppLogo from './AppLogo.vue';

const page: Page = usePage();
const role: string = page.props.auth.user.role;
const mainNavItems: NavItem[] = [
    {
        title: 'Dashboard',
        href: `/${role}/dashboard`,
        icon: LayoutGrid,
    },
    {
        title: 'Restaurant',
        href: `/${role}/restaurant`,
        icon: HandPlatter,
    },
];
if (role !== 'admin') {
    mainNavItems.push({
        title: 'Menu',
        href: `/${role}/menu`,
        icon: BookOpen,
    });
}

const footerNavItems: NavItem[] = [];
</script>

<template>
    <Sidebar collapsible="icon" variant="inset">
        <SidebarHeader>
            <SidebarMenu>
                <SidebarMenuItem>
                    <SidebarMenuButton size="lg" as-child>
                        <Link :href="route(`${role}.dashboard`)">
                            <AppLogo />
                        </Link>
                    </SidebarMenuButton>
                </SidebarMenuItem>
            </SidebarMenu>
        </SidebarHeader>

        <SidebarContent>
            <NavMain :items="mainNavItems" />
        </SidebarContent>

        <SidebarFooter>
            <NavFooter :items="footerNavItems" />
            <NavUser />
        </SidebarFooter>
    </Sidebar>
    <slot />
</template>
