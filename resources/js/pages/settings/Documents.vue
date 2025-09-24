<script setup lang="ts">
import { Head } from '@inertiajs/vue3';

import AppearanceTabs from '@/components/AppearanceTabs.vue';
import HeadingSmall from '@/components/HeadingSmall.vue';
import { type BreadcrumbItem } from '@/types';

import { useForm } from '@inertiajs/vue3'
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import file, { index, store } from '@/routes/file';
import { Media } from '@/types';
import FileUpload from '@/components/FileUpload.vue';
import { FileMetadata } from '@/composables/useFileUpload';


const breadcrumbItems: BreadcrumbItem[] = [
    {
        title: 'Document settings',
        href: index().url,
    },
];

defineProps<{
    documents: FileMetadata[];
}>()


const form = useForm({
  file: null,
})

function submit() {
  form.post(store().url)
}
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbItems">
        <Head title="Appearance settings" />

        <SettingsLayout>
            <div class="space-y-6">
                <HeadingSmall 
                title="Documents" 
                description="Upload documents" />
                <div>
                    <form @submit.prevent="submit">
                      <input type="file" @input="form.file = $event.target.files[0]" />
                      <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                      </progress>
                      <button type="submit">Submit</button>
                    </form>
                </div>
                <FileUpload :initial-files="documents" />
            </div>
        </SettingsLayout>
    </AppLayout>
</template>
