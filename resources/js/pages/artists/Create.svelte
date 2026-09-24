<script module lang="ts">

    export const layout = {
        breadcrumbs: [
            {
                title: "Dashboard",
                href: dashboardIndex(),
            },
            {
                title: "Artists",
                href: artistsIndex(),
            },
            {
                title: "Artists Create",
                href: artistsCreate(),
            },
        ],
    };
</script>

<script lang="ts">
    import { index as dashboardIndex } from "@/routes/dashboard";
    import { index as artistsIndex } from "@/routes/artists";
    import { store as artistsStore } from "@/routes/artists";
    import { create as artistsCreate } from '@/routes/artists';
    import { edit as artistsEdit } from '@/routes/artists';

    import { Form } from "@inertiajs/svelte";
    import AppHead from "@/components/AppHead.svelte";
    import { Button } from "@/components/ui/button";
    import InputError from "@/components/InputError.svelte";
    import { Input } from "@/components/ui/input";
    import { Label } from "@/components/ui/label";
    import { Spinner } from '@/components/ui/spinner';
    import { Link } from '@inertiajs/svelte';
    import { toUrl } from '@/lib/utils';
</script>

<AppHead title="إضافة فنان جديد" />

<div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6" dir="rtl">
    <div class="relative flex-1 rounded-xl border border-sidebar-border/70 bg-white dark:bg-zinc-900 shadow-sm">

        <!-- Header -->
        <div class="p-6 border-b border-sidebar-border/70 flex items-center justify-between">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    إضافة فنان جديد
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    أدخل تفاصيل الفنان الجديد لإضافته إلى النظام.
                </p>
            </div>
            <Link href={toUrl(artistsIndex())} class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded">
                العودة للقائمة
            </Link>
            <Button variant="outline" href={artistsIndex()}>

            </Button>
        </div>

        <!-- Form Body -->
        <div class="p-6 max-w-2xl mx-auto">
            <Form
                action={toUrl(artistsStore())}
                method="post"
                class="space-y-6"
            >
                {#snippet children({ errors, processing })}

                    <!-- Artist Name Field -->
                    <div class="grid gap-2">
                        <Label for="name" class="font-semibold text-gray-700 dark:text-gray-200">
                            اسم الفنان
                            <span class="text-red-500">*</span>
                        </Label>
                        <Input
                            id="name"
                            type="text"
                            name="name"
                            required
                            autocomplete="off"
                            placeholder="أدخل اسم الفنان"
                            class="text-right"
                        />
                        <InputError message={errors.name} />
                    </div>

                    <!-- Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-zinc-800">

                        <Link href={toUrl(artistsIndex())} >
                            <Button
                                class="cursor-pointer"
                                type="button"
                                variant="ghost"
                                disabled={processing}>
                                إلغاء
                            </Button>
                        </Link>

                        <Button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white min-w-[120px] cursor-pointer"
                            disabled={processing}
                        >
                            {#if processing}
                                <Spinner class="ml-2" />
                            {/if}
                            حفظ الفنان
                        </Button>
                    </div>

                {/snippet}
            </Form>
        </div>

    </div>
</div>
