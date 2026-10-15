<script module lang="ts">

    export const layout = {
        breadcrumbs: [
            {
                title: 'Dashboard',
                href: dashboardIndex(),
            },
        ],
    };
</script>

<script lang="ts">
    type DashboardSong = {
        id: number;
        title: string;
        song_no: string;
        link: string | null;
        subscription_detail: string | null;
        code: string;
        is_active: boolean;
        artist: { name: string };
        sim: { name: string };
    };

import AppHead from '@/components/AppHead.svelte';
import { Link, page, router } from '@inertiajs/svelte';
import { index as dashboardIndex } from '@/routes/dashboard';
import { create as dashboardCreate } from '@/routes/dashboard';
import { store as dashboardStore } from '@/routes/dashboard';
import { edit as dashboardEdit } from '@/routes/dashboard';
import { destroy as dashboardDestroy } from '@/routes/dashboard';
import { toUrl } from '@/lib/utils';
import { Badge } from "@/components/ui/badge";

    let {
        songs = [],
        service = {
            title: "اجعل كل اتصال يعبر عن شخصيتك",
            description: "خدمة Ring Back Tone (RBT) تمنحك الفرصة لاستبدال نغمة الرنين التقليدية بمقطع صوتي أو أغنية مميزة يستمع إليها المتصلون بك قبل الرد...",
            instructions: "الخدمة متوفرة على شبكة زين السودان...",
            price: 1184,
            currency: "جنية سوداني شاملة القيمة المضافة",
            duration: "لمدة 60 يومًا"
        }
    }: {
        songs?: DashboardSong[];
        service?: {
            title: string;
            description: string;
            instructions: string;
            price: number;
            currency: string;
            duration: string;
        };
    } = $props();

    // Svelte 5 reactive fine-grained state indicator
    let isSubscribed = $state(false);
    let audioPlayer: HTMLAudioElement | undefined = $state();
    let currentSongId = $state<number | null>(null);
    let isPlaying = $state(false);
    let playbackError = $state(false);

    function handleSubscribe() {
        isSubscribed = true;
        alert('تم تقديم طلب الاشتراك بنجاح عبر الرقم 1717!');
    }

    function quickSubscribe(code: string, title: string) {
        alert(`جاري الاشتراك في نغمة "${title}" عبر الرمز ${code}...`);
    }

    async function togglePlayback(song: DashboardSong) {
        if (!song.link || !song.is_active || !audioPlayer) {
            return;
        }

        playbackError = false;

        if (currentSongId === song.id && isPlaying) {
            stopPlayback();
            return;
        }

        currentSongId = song.id;
        isPlaying = false;
        audioPlayer.src = song.link;

        try {
            await audioPlayer.play();

            if (currentSongId === song.id) {
                isPlaying = true;
            }
        } catch {
            if (currentSongId === song.id) {
                playbackError = true;
                isPlaying = false;
            }
        }
    }

    function stopPlayback() {
        if (!audioPlayer) {
            return;
        }

        audioPlayer.pause();
        audioPlayer.currentTime = 0;
        currentSongId = null;
        isPlaying = false;
    }

    function handlePlaybackEnded() {
        currentSongId = null;
        isPlaying = false;
    }

    function handlePlaybackError() {
        playbackError = true;
        isPlaying = false;
    }

    function handleDelete(id: number) {
        if (confirm('هل أنت تأكد من حذف هذه الأغنية')) {
            router.delete(toUrl(dashboardDestroy(id)));
        }
    }

</script>

<!-- 3. TEMPLATE MARKUP SECTION -->
<AppHead title="Dashboard" />

<div class="flex h-full flex-1 flex-col gap-4 p-4 overflow-x-auto rounded-xl">

    <!-- Top Service Header Info Card -->
    <div class="relative rounded-xl p-6 bg-white dark:bg-zinc-900 border border-sidebar-border/70">

        <div class="max-w-4xl mx-auto font-sans text-center">

            <h1 class="text-2xl md:text-3xl font-bold text-gray-900 dark:text-white mb-4">
                {service.title}
            </h1>

            <div class="text-gray-600 dark:text-gray-300 leading-relaxed max-w-3xl mx-auto space-y-4 mb-6">
                <p>
                    خدمة <span class="bg-blue-600 text-white px-1.5 py-0.5 rounded font-semibold text-sm inline-block" dir="ltr">Ring Back Tone</span> (RBT)
                    {service.description.split('(RBT)')[1] || service.description}
                </p>
                <p class="text-sm text-gray-400">
                    {service.instructions}
                </p>
            </div>

            <div class="inline-flex items-center justify-center bg-green-50 dark:bg-green-950/30 text-green-700 dark:text-green-400 font-medium px-6 py-2.5 rounded-full border border-green-200 dark:border-green-900 text-base mb-6">
                <span>{service.currency}</span>
                <strong class="mx-1.5 text-green-800 dark:text-green-300">{service.price}</strong>
                <span>:رسوم الاشتراك</span>
                <span class="ms-1 text-gray-400">|</span>
                <span class="ms-1">{service.duration}</span>
            </div>

        </div>

    </div>

    <!-- The Audio RBT Table Component -->
    <div class="relative flex-1 rounded-xl border border-sidebar-border/70 bg-white dark:bg-zinc-900 overflow-hidden shadow-sm">

        <div class="text-right p-4 border-b border-sidebar-border/70">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">قائمة الأغاني والنغمات المتاحة</h2>
            <p class="text-xs text-gray-500">اختر نغمتك المفضلة واستخدم رمز الاشتراك السريع</p>
            {#if playbackError}
                <p class="mt-3 text-sm font-semibold text-red-600 dark:text-red-400" role="alert">
                    تعذر تشغيل هذا المقطع. تحقق من رابط الأغنية وحاول مرة أخرى.
                </p>
            {/if}
            <Link href={toUrl(dashboardCreate())} class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded">
                أضافة اغنية جديدة
            </Link>
        </div>

        <div class="overflow-x-auto w-full">
            <table class="w-full text-sm text-right text-gray-500 dark:text-gray-400" dir="rtl">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-zinc-800 dark:text-gray-300">
                    <tr>
                        <th scope="col" class="px-6 py-3 font-semibold">إسم الفنان</th>
                        <th scope="col" class="px-6 py-3 font-semibold">اسم الأغنية</th>
                        <th scope="col" class="px-6 py-3 font-semibold">رقم الأغنية</th>
                        <th scope="col" class="px-6 py-3 font-semibold text-center">الاستماع</th>
                        <th scope="col" class="px-6 py-3 font-semibold">مزود الخدمة</th>
                        <th scope="col" class="px-6 py-3 font-semibold">طريقة الاشتراك اليدوي</th>
                        <th scope="col" class="px-6 py-3 font-semibold">الحالة</th>
                        <th scope="col" class="px-6 py-3 font-semibold text-center">الاشتراك السريع</th>
                        <th scope="col" class="px-6 py-3 font-semibold text-center">العمليات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-zinc-800">
                    {#each songs as song}
                        <tr class="bg-white dark:bg-zinc-900 hover:bg-gray-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {song.artist.name}
                            </td>
                            <td class="px-6 py-4 font-medium text-blue-600 dark:text-blue-400">
                                {song.title}
                            </td>
                            <td class="px-6 py-4 font-mono tracking-wider">
                                {song.song_no}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button
                                    type="button"
                                    onclick={() => togglePlayback(song)}
                                    disabled={!song.link || !song.is_active}
                                    aria-label={currentSongId === song.id && isPlaying ? `إيقاف ${song.title}` : `استمع إلى ${song.title}`}
                                    title={!song.is_active ? 'هذه النغمة غير متاحة' : !song.link ? 'لا يوجد رابط صوتي لهذه الأغنية' : currentSongId === song.id && isPlaying ? 'إيقاف' : 'استماع'}
                                    class={`p-1.5 rounded-full transition-all disabled:cursor-not-allowed disabled:opacity-40 ${
                                        currentSongId === song.id && isPlaying
                                            ? 'text-red-600 hover:bg-red-50 dark:text-red-400 dark:hover:bg-red-950/40'
                                            : 'text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 hover:bg-gray-100 dark:hover:bg-zinc-700'
                                    }`}
                                >
                                    {#if currentSongId === song.id && isPlaying}
                                        <svg class="w-5 h-5 mx-auto" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <rect x="5" y="4" width="3" height="12" rx="1" />
                                            <rect x="12" y="4" width="3" height="12" rx="1" />
                                        </svg>
                                    {:else}
                                        <svg class="w-5 h-5 mx-auto" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M6.5 4.8a1 1 0 0 1 1.5-.86l8.1 4.7a1.55 1.55 0 0 1 0 2.68L8 16a1 1 0 0 1-1.5-.86V4.8Z" />
                                        </svg>
                                    {/if}
                                </button>
                            </td>
                            <td class="px-6 py-4 font-mono tracking-wider">
                                {song.sim.name}
                            </td>
                            <td class="px-6 py-4 font-mono tracking-wider">
                                {song.subscription_detail}
                            </td>
                            <td class="px-6 py-4 font-mono tracking-wider">
                            {#if song.is_active}
                                <Badge class="bg-green-50 text-green-700 dark:bg-green-950 dark:text-green-300">
                                    متاح
                                </Badge>
                                <!-- <span class="text-green-600 dark:text-green-400 font-semibold">متاح</span> -->
                            {:else}
                                <Badge class="bg-red-50 text-red-700 dark:bg-red-950 dark:text-red-300">
                                    غير متاح
                                </Badge>
                            {/if}
                            </td>
                            <!-- <td class="px-6 py-4 text-xs text-gray-600 dark:text-gray-400 max-w-xs">
                                إرسال <span class="font-mono bg-gray-100 dark:bg-zinc-800 px-1 py-0.5 rounded font-bold text-gray-800 dark:text-zinc-200">{song.fast_subscription}</span> إلى <span class="font-mono text-blue-600 font-bold">1717</span> ثم قم بإرسال الرسالة
                            </td> -->
                            <td class="px-6 py-4 text-center">
                                <button
                                    onclick={() => quickSubscribe(song.code, song.title)}
                                    class="inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/40 dark:hover:bg-blue-900/60 text-blue-600 dark:text-blue-400 text-xs font-semibold px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-900 transition-all">
                                    <span>اضغط لإرسال الرسالة</span>
                                </button>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <Link href={toUrl(dashboardEdit(song.id))}>
                                    <button class="cursor-pointer inline-flex items-center gap-1 bg-blue-50 hover:bg-blue-100 dark:bg-blue-950/40 dark:hover:bg-blue-900/60 text-blue-600 dark:text-blue-400 text-xs font-semibold px-3 py-1.5 rounded-lg border border-blue-200 dark:border-blue-900 transition-all">
                                        <span>تعديل</span>
                                    </button>
                                </Link>
                                <!-- Delete Button -->
                                <button
                                    type="button"
                                    onclick={() => handleDelete(song.id)}
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

<audio bind:this={audioPlayer} onended={handlePlaybackEnded} onerror={handlePlaybackError} class="hidden"></audio>
