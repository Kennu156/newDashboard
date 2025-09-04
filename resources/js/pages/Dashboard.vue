<script setup lang="ts">
import { Button } from '@/components/ui/button';
import { Label } from '@/components/ui/label';
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/AppLayout.vue';
import { dashboard } from '@/routes';
import { UserData, type BreadcrumbItem } from '@/types';
import { Head, router } from '@inertiajs/vue3';
import { ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

defineProps<{
    name?: string;
    userData: UserData | null;
    absenceData: any;
}>();

const tahvelCookie = ref<string>();

// https://tahvel.edu.ee/hois_back/user

const saveTahvelCookie = () => {
    router.put('/save-tahvel-cookie', {
        tahvel_cookie: tahvelCookie.value,
    });
};
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4">
            <div>
                <Label>Tahvel auth tahvel-cookie</Label>
                <Textarea class="" v-model="tahvelCookie"></Textarea>
                <p class="text-xs text-destructive" v-show="$page.props.errors.tahvel_cookie">
                    {{ $page.props.errors.tahvel_cookie }}
                </p>
            </div>
            <div><Button @click="saveTahvelCookie">Save</Button></div>
            <Table>
                <TableCaption>A list of absence data.</TableCaption>
                <TableHeader>
                    <TableRow>
                        <TableHead class="w-[100px]">Field</TableHead>
                        <TableHead>Value</TableHead>
                    </TableRow>
                </TableHeader>
                <TableBody>
                    <TableRow v-for="(value, key) in absenceData" :key="key">
                        <TableCell class="font-medium">{{ key }}</TableCell>
                        <TableCell>{{ value }}</TableCell>
                    </TableRow>
                </TableBody>
            </Table>

            <pre>{{ userData }}</pre>
        </div>
    </AppLayout>
</template>
