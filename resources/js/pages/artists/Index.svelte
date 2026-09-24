<!-- 2. MODULE SCRIPT: Strictly handles static layout wrapping configurations -->
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
        ],
    };
</script>

<script lang="ts">

import { index as dashboardIndex } from "@/routes/dashboard";
import { index as artistsIndex } from '@/routes/artists';
import { create as artistsCreate } from '@/routes/artists';
import { edit as artistsEdit } from '@/routes/artists';
import { destroy as artistsDestroy } from '@/routes/artists';

import AppHead from "@/components/AppHead.svelte";
import { Button } from "@/components/ui/button";
import { toUrl } from '@/lib/utils';
import { Link, page, router } from '@inertiajs/svelte';
import { Form } from "@inertiajs/svelte";

    // Unpack data passed down by Laravel seamlessly using Svelte 5 props rune
    let { artists = [] } = $props();

    // Dynamically reactive flash success message from Inertia page props
    let flashSuccess = $derived(page.props.flash?.success);
    console.log('Flash Success:', flashSuccess);
    let showNotification = $state(true);

    function dismissNotification() {
        showNotification = false;
    }

    function handleDelete(id: number) {
        if (confirm('هل أنت تأكد من حذف هذا الفنان؟')) {
            router.delete(toUrl(artistsDestroy(id)));
        }
    }

</script>

<!-- 3. TEMPLATE MARKUP SECTION -->
<AppHead title="Artists" />

<!-- In template markup -->


<div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto rounded-xl">
{#if flashSuccess && showNotification}
    <div class="p-4 mb-2 text-sm text-emerald-800 bg-emerald-50 rounded-xl">
        {flashSuccess}
    </div>
{/if}
    <!-- Top Service Header Info Card -->
    <!-- <div class="relative rounded-xl p-6 bg-white dark:bg-zinc-900 border border-sidebar-border/70">
        <div class="max-w-4xl mx-auto font-sans text-center">

        </div>
    </div> -->

    <!-- The Audio RBT Table Component -->
    <div class="relative flex-1 rounded-xl border border-sidebar-border/70 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">
        <div class="text-right p-4 border-b border-sidebar-border/70">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">
                قائمة الفنانين
            </h2>
            <div class="flex-end flex-wrap items-center gap-2 md:flex-row">

                <Link href={toUrl(artistsCreate())} class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded">
                    أضافة فنان
                </Link>
                <!-- href={toUrl(artistsCreate())} -->
            </div>
        </div>

        <div class="overflow-x-auto w-full">
            <table
                class="w-full text-sm text-right text-gray-500 dark:text-gray-400"
                dir="rtl"
            >
                <thead
                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-800 dark:text-gray-300"
                >
                    <tr>
                        <th scope="col" class="px-6 py-3 font-semibold"
                            >إسم الفنان</th
                        >
                        <th
                            scope="col"
                            class="px-6 py-3 font-semibold text-center"
                            >الاشتراك السريع</th
                        >
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-800">
                    {#each artists as artist}
                        <tr class="bg-white dark:bg-zinc-900 hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {artist.name}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <Link href={toUrl(artistsEdit(artist.id))}>
                                    <button class="cursor-pointer inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/40 dark:hover:bg-blue-900/60 text-blue-600 dark:text-blue-400 text-xs font-semibold px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-900 transition-all">
                                        <span>تعديل</span>
                                    </button>
                                </Link>
                                <!-- Delete Button -->
                                <button
                                    type="button"
                                    onclick={() => handleDelete(artist.id)}
                                    class="cursor-pointer inline-flex items-center gap-1 bg-red-50 hover:bg-red-100 dark:bg-red-950/40 dark:hover:bg-red-900/60 text-red-600 dark:text-red-400 text-xs font-semibold px-3 py-1.5 rounded-lg border border-red-200 dark:border-red-900 transition-all"
                                >
                                    <span>حذف</span>
                                </button>
                            </td>
                        </tr>
                    {/each}
                </tbody>
            </table>
        </div>
    </div>
</div>
