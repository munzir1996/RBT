<script lang="ts">
    import { Link, page } from '@inertiajs/svelte';
    import AppHead from '@/components/AppHead.svelte';
    import { toUrl } from '@/lib/utils';
    import { index as dashboardIndex } from '@/routes/dashboard';
    import { login, register } from '@/routes';

    type Song = {
        id: number;
        title: string;
        song_no: string;
        link: string | null;
        subscription_detail: string | null;
        fast_subscription: string | null;
        is_active: boolean;
        artist: { name: string };
        sim: { name: string };
    };

    type Service = {
        title: string;
        description: string;
        instructions: string;
        price: number;
        currency: string;
        duration: string;
    };

    let {
        songs = [],
        service = {
            title: 'اجعل كل اتصال يعبر عن شخصيتك',
            description:
                'خدمة Ring Back Tone (RBT) تمنحك الفرصة لاستبدال نغمة الرنين التقليدية بمقطع صوتي أو أغنية مميزة يستمع إليها المتصلون بك قبل الرد...',
            instructions: 'الخدمة متوفرة على شبكة زين السودان...',
            price: 1184,
            currency: "جنية سوداني شاملة القيمة المضافة",
            duration: 'لمدة 60 يومًا',
        },
    }: { songs?: Song[]; service?: Service } = $props();

    const auth = $derived(page.props.auth);
    let audioPlayer: HTMLAudioElement | undefined = $state();
    let currentSongId = $state<number | null>(null);
    let isPlaying = $state(false);
    let playbackError = $state(false);

    async function togglePlayback(song: Song) {
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
</script>

<AppHead title="Ring Back Tone">
    <meta
        name="description"
        content="استكشف قائمة الأغاني والنغمات المتاحة لخدمة Ring Back Tone."
    />
</AppHead>

<div
    dir="rtl"
    class="min-h-screen overflow-hidden bg-slate-50 text-slate-900 dark:bg-[#090d18] dark:text-slate-100"
>
    <header class="relative z-10 border-b border-slate-200/80 bg-white/85 backdrop-blur-xl dark:border-white/10 dark:bg-slate-950/75">
        <nav class="mx-auto flex w-full max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="#top" class="flex items-center gap-3" aria-label="العودة إلى أعلى الصفحة">
                <span class="flex size-11 items-center justify-center rounded-2xl bg-gradient-to-br from-indigo-600 to-violet-500 text-white shadow-lg shadow-indigo-600/20">
                    <svg viewBox="0 0 24 24" class="size-6" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 13v-2a8 8 0 0 1 16 0v2" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 13h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4Zm16 0h-2a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-4Z" />
                    </svg>
                </span>
                <span>
                    <span class="block text-base font-extrabold tracking-tight">نغمتي</span>
                    <span class="block text-[10px] font-semibold uppercase tracking-[0.2em] text-slate-500 dark:text-slate-400" dir="ltr">Ring Back Tone</span>
                </span>
            </a>

            <div class="flex items-center gap-2 sm:gap-3">
                {#if auth.user}
                    <Link
                        href={toUrl(dashboardIndex())}
                        class="rounded-xl border border-slate-200 px-4 py-2 text-sm font-bold text-slate-700 transition hover:border-indigo-300 hover:text-indigo-700 dark:border-white/15 dark:text-slate-200 dark:hover:border-indigo-400 dark:hover:text-indigo-300"
                    >
                       Ring Back Tone Dashboard
                    </Link>
                {:else}
                    <!-- <Link
                        href={toUrl(login())}
                        class="rounded-xl px-3 py-2 text-sm font-bold text-slate-600 transition hover:text-indigo-700 dark:text-slate-300 dark:hover:text-indigo-300"
                    >
                        تسجيل الدخول
                    </Link> -->
                    <!-- <Link
                        href={toUrl(register())}
                        class="rounded-xl bg-indigo-600 px-4 py-2 text-sm font-bold text-white shadow-lg shadow-indigo-600/20 transition hover:bg-indigo-500"
                    >
                        إنشاء حساب
                    </Link> -->
                {/if}
            </div>
        </nav>
    </header>

    <main id="top" class="mx-auto w-full max-w-7xl px-4 pb-16 pt-8 sm:px-6 sm:pt-12 lg:px-8">
        <section class="relative isolate overflow-hidden rounded-[2rem] bg-slate-950 px-6 py-10 text-white shadow-2xl shadow-indigo-950/15 sm:px-10 sm:py-14 lg:px-14 lg:py-16">
            <div class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_15%_15%,rgba(99,102,241,0.45),transparent_38%),radial-gradient(ellipse_at_85%_85%,rgba(139,92,246,0.3),transparent_38%)]"></div>
            <div class="absolute -left-20 top-10 -z-10 size-64 rounded-full border border-white/10"></div>
            <div class="absolute -left-10 top-20 -z-10 size-44 rounded-full border border-white/10"></div>

            <div class="grid items-center gap-10 lg:grid-cols-[1fr_auto]">
                <div class="max-w-3xl">
                    <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-bold text-indigo-100 backdrop-blur">
                        <span class="size-2 rounded-full bg-emerald-400 shadow-[0_0_12px_rgba(52,211,153,0.8)]"></span>
                        نغمات تليق بك وبكل اتصال
                    </div>
                    <h1 class="text-3xl font-black leading-tight tracking-tight sm:text-4xl lg:text-5xl">
                        {service.title}
                    </h1>
                    <div class="mt-5 max-w-2xl space-y-3 text-sm leading-8 text-slate-300 sm:text-base">
                        <p>
                            خدمة
                            <span class="mx-1 inline-block rounded-md bg-indigo-500 px-2 py-0.5 text-xs font-bold text-white" dir="ltr">Ring Back Tone</span>
                            (RBT)
                            {service.description.split('(RBT)')[1] || service.description}
                        </p>
                        <p class="text-sm text-slate-400">{service.instructions}</p>
                    </div>

                    <div class="mt-7 flex flex-wrap items-center gap-3">
                        <a
                            href="#songs"
                            class="inline-flex items-center gap-2 rounded-xl bg-white px-5 py-3 text-sm font-extrabold text-slate-950 shadow-lg transition hover:-translate-y-0.5 hover:bg-indigo-50"
                        >
                            اكتشف الأغاني
                            <svg viewBox="0 0 20 20" class="size-4" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m7 4 6 6-6 6" />
                            </svg>
                        </a>
                        <span class="text-sm font-medium text-slate-300">استمع إلى نغماتك المفضلة قبل الاختيار</span>
                    </div>
                </div>

                <div class="mx-auto flex size-44 items-center justify-center rounded-full border border-white/15 bg-white/[0.06] shadow-[0_0_80px_rgba(99,102,241,0.2)] sm:size-56">
                    <div class="flex size-32 items-center justify-center rounded-full bg-gradient-to-br from-indigo-500 to-violet-600 shadow-2xl shadow-indigo-900/60 sm:size-40">
                        <svg viewBox="0 0 24 24" class="size-16 sm:size-20" fill="none" stroke="currentColor" stroke-width="1.25" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                            <circle cx="6" cy="18" r="3" />
                            <circle cx="18" cy="16" r="3" />
                        </svg>
                    </div>
                </div>
            </div>

            <div class="mt-10 flex flex-wrap items-center gap-x-7 gap-y-3 border-t border-white/10 pt-6 text-sm text-slate-300">
                <div class="flex items-center gap-2">
                    <span>{service.currency}</span>
                    <strong class="text-white">{service.price}</strong>
                    <span class="font-semibold text-white">:رسوم الاشتراك</span>
                </div>
                <span class="hidden text-white/25 sm:inline">•</span>
                <span>{service.duration}</span>
            </div>
        </section>

        <section id="songs" class="scroll-mt-8 pt-12 sm:pt-16">
            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <p class="mb-2 text-xs font-extrabold uppercase tracking-[0.2em] text-indigo-600 dark:text-indigo-400">اختيارك يبدأ من هنا</p>
                    <h2 class="text-2xl font-black tracking-tight sm:text-3xl">قائمة الأغاني والنغمات المتاحة</h2>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">اختر نغمتك المفضلة واستمع إليها قبل الاشتراك السريع</p>
                </div>
                <div class="flex w-fit items-center gap-3 rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm dark:border-white/10 dark:bg-white/[0.04]">
                    <span class="flex size-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-300">
                        <svg viewBox="0 0 24 24" class="size-5" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                            <circle cx="6" cy="18" r="3" />
                            <circle cx="18" cy="16" r="3" />
                        </svg>
                    </span>
                    <span>
                        <span class="block text-lg font-black leading-none">{songs.length}</span>
                        <span class="mt-1 block text-xs font-medium text-slate-500 dark:text-slate-400">نغمة في القائمة</span>
                    </span>
                </div>
            </div>

            {#if playbackError}
                <p class="mb-4 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-700 dark:border-rose-900/60 dark:bg-rose-950/30 dark:text-rose-300" role="alert">
                    تعذر تشغيل هذا المقطع. تحقق من رابط الأغنية وحاول مرة أخرى.
                </p>
            {/if}

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl shadow-slate-900/5 dark:border-white/10 dark:bg-slate-900/70 dark:shadow-black/20">
                <div class="grid gap-3 p-3 sm:grid-cols-2 lg:hidden">
                    {#each songs as song (song.id)}
                        <article class="rounded-2xl border border-slate-200 bg-slate-50/70 p-4 dark:border-white/10 dark:bg-white/[0.03]">
                            <dl class="grid gap-4">
                                <div>
                                    <dt class="text-xs font-bold text-slate-500 dark:text-slate-400">اسم الأغنية</dt>
                                    <dd class="mt-1 break-words text-base font-extrabold text-indigo-700 dark:text-indigo-300">{song.title}</dd>
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div class="min-w-0">
                                        <dt class="text-xs font-bold text-slate-500 dark:text-slate-400">إسم الفنان</dt>
                                        <dd class="mt-1 break-words text-sm font-semibold text-slate-700 dark:text-slate-200">{song.artist.name}</dd>
                                    </div>
                                    <div class="min-w-0">
                                        <dt class="text-xs font-bold text-slate-500 dark:text-slate-400">رقم الأغنية</dt>
                                        <dd class="mt-1 break-all font-mono text-sm text-slate-600 dark:text-slate-300">{song.song_no}</dd>
                                    </div>
                                </div>
                            </dl>

                            <div class="mt-4 grid gap-2 border-t border-slate-200 pt-4 dark:border-white/10">
                                <button
                                    type="button"
                                    onclick={() => togglePlayback(song)}
                                    disabled={!song.link || !song.is_active}
                                    aria-label={currentSongId === song.id && isPlaying ? `إيقاف ${song.title}` : `استمع إلى ${song.title}`}
                                    title={!song.is_active ? 'هذه النغمة غير متاحة' : !song.link ? 'لا يوجد رابط صوتي لهذه الأغنية' : currentSongId === song.id && isPlaying ? 'إيقاف' : 'استماع'}
                                    class={`inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-xl px-3 py-2 text-xs font-bold transition disabled:cursor-not-allowed disabled:opacity-40 ${
                                        currentSongId === song.id && isPlaying
                                            ? 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-300'
                                            : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300'
                                    }`}
                                >
                                    {#if currentSongId === song.id && isPlaying}
                                        <svg viewBox="0 0 20 20" class="size-4" fill="currentColor" aria-hidden="true">
                                            <rect x="5" y="4" width="3" height="12" rx="1" />
                                            <rect x="12" y="4" width="3" height="12" rx="1" />
                                        </svg>
                                        إيقاف
                                    {:else}
                                        <svg viewBox="0 0 20 20" class="size-4" fill="currentColor" aria-hidden="true">
                                            <path d="M6.5 4.8a1 1 0 0 1 1.5-.86l8.1 4.7a1.55 1.55 0 0 1 0 2.68L8 16a1 1 0 0 1-1.5-.86V4.8Z" />
                                        </svg>
                                        استماع
                                    {/if}
                                </button>
                                {#if song.is_active && song.fast_subscription}
                                    <a
                                        href={`sms:1717?body=${encodeURIComponent(song.fast_subscription)}`}
                                        class="inline-flex min-h-11 w-full items-center justify-center rounded-xl bg-indigo-600 px-3.5 py-2 text-center text-xs font-extrabold text-white shadow-md shadow-indigo-600/15 transition hover:bg-indigo-500"
                                    >
                                        اضغط لإرسال الرسالة
                                    </a>
                                {:else}
                                    <span class="inline-flex min-h-11 items-center justify-center rounded-xl bg-slate-100 px-3 py-2 text-center text-xs font-semibold text-slate-400 dark:bg-white/[0.04]">الاشتراك السريع غير متاح حاليًا</span>
                                {/if}
                            </div>
                        </article>
                    {:else}
                        <div class="rounded-2xl border border-dashed border-slate-200 px-4 py-10 text-center sm:col-span-2 dark:border-white/10">
                            <p class="font-bold text-slate-700 dark:text-slate-200">لا توجد أغانٍ في القائمة بعد</p>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">ستظهر النغمات المتاحة هنا عند إضافتها.</p>
                        </div>
                    {/each}
                </div>

                <div class="hidden overflow-x-auto lg:block">
                    <table class="w-full min-w-[960px] text-right text-sm">
                        <thead class="bg-slate-100/80 text-xs font-extrabold text-slate-600 dark:bg-white/[0.04] dark:text-slate-300">
                            <tr>
                                <th scope="col" class="px-5 py-4">إسم الفنان</th>
                                <th scope="col" class="px-5 py-4">اسم الأغنية</th>
                                <th scope="col" class="px-5 py-4">رقم الأغنية</th>
                                <th scope="col" class="px-5 py-4">الاستماع</th>
                                <!-- <th scope="col" class="px-5 py-4">مزود الخدمة</th> -->
                                <!-- <th scope="col" class="px-5 py-4">طريقة الاشتراك اليدوي</th> -->
                                <!-- <th scope="col" class="px-5 py-4">الحالة</th> -->
                                <th scope="col" class="px-5 py-4">الاشتراك السريع</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-white/5">
                            {#each songs as song (song.id)}
                                <tr class="transition hover:bg-indigo-50/50 dark:hover:bg-indigo-400/[0.04]">
                                    <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-700 dark:text-slate-200">{song.artist.name}</td>
                                    <td class="whitespace-nowrap px-5 py-4 font-extrabold text-indigo-700 dark:text-indigo-300">{song.title}</td>
                                    <td class="whitespace-nowrap px-5 py-4 font-mono text-slate-500 dark:text-slate-400">{song.song_no}</td>
                                    <td class="px-5 py-4">
                                        <button
                                            type="button"
                                            onclick={() => togglePlayback(song)}
                                            disabled={!song.link || !song.is_active}
                                            aria-label={currentSongId === song.id && isPlaying ? `إيقاف ${song.title}` : `استمع إلى ${song.title}`}
                                            title={!song.is_active ? 'هذه النغمة غير متاحة' : !song.link ? 'لا يوجد رابط صوتي لهذه الأغنية' : currentSongId === song.id && isPlaying ? 'إيقاف' : 'استماع'}
                                            class={`inline-flex items-center gap-2 rounded-xl px-3 py-2 text-xs font-bold transition disabled:cursor-not-allowed disabled:opacity-40 ${
                                                currentSongId === song.id && isPlaying
                                                    ? 'bg-rose-50 text-rose-700 dark:bg-rose-500/10 dark:text-rose-300'
                                                    : 'bg-indigo-50 text-indigo-700 dark:bg-indigo-500/10 dark:text-indigo-300'
                                            }`}
                                        >
                                            {#if currentSongId === song.id && isPlaying}
                                                <svg viewBox="0 0 20 20" class="size-4" fill="currentColor" aria-hidden="true">
                                                    <rect x="5" y="4" width="3" height="12" rx="1" />
                                                    <rect x="12" y="4" width="3" height="12" rx="1" />
                                                </svg>
                                                إيقاف
                                            {:else}
                                                <svg viewBox="0 0 20 20" class="size-4" fill="currentColor" aria-hidden="true">
                                                    <path d="M6.5 4.8a1 1 0 0 1 1.5-.86l8.1 4.7a1.55 1.55 0 0 1 0 2.68L8 16a1 1 0 0 1-1.5-.86V4.8Z" />
                                                </svg>
                                                استماع
                                            {/if}
                                        </button>
                                    </td>
                                    <!-- <td class="whitespace-nowrap px-5 py-4 text-slate-600 dark:text-slate-300">{song.sim.name}</td> -->
                                    <!-- <td class="px-5 py-4 text-slate-500 dark:text-slate-400">{song.subscription_detail || '—'}</td> -->
                                    <!-- <td class="px-5 py-4">
                                        {#if song.is_active}
                                            <span class="inline-flex items-center gap-2 rounded-full bg-emerald-50 px-3 py-1 text-xs font-bold text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-300">
                                                <span class="size-1.5 rounded-full bg-emerald-500"></span>
                                                متاح
                                            </span>
                                        {:else}
                                            <span class="inline-flex items-center gap-2 rounded-full bg-rose-50 px-3 py-1 text-xs font-bold text-rose-700 dark:bg-rose-500/10 dark:text-rose-300">
                                                <span class="size-1.5 rounded-full bg-rose-500"></span>
                                                غير متاح
                                            </span>
                                        {/if}
                                    </td> -->
                                    <td class="px-5 py-4">
                                        {#if song.is_active && song.fast_subscription}
                                            <a
                                                href={`sms:1717?body=${encodeURIComponent(song.fast_subscription)}`}
                                                class="inline-flex items-center justify-center whitespace-nowrap rounded-xl bg-indigo-600 px-3.5 py-2 text-xs font-extrabold text-white shadow-md shadow-indigo-600/15 transition hover:-translate-y-0.5 hover:bg-indigo-500"
                                            >
                                                اضغط لإرسال الرسالة
                                            </a>
                                        {:else}
                                            <span class="text-xs font-semibold text-slate-400">غير متاح حاليًا</span>
                                        {/if}
                                    </td>
                                </tr>
                            {:else}
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="mx-auto flex size-14 items-center justify-center rounded-2xl bg-indigo-50 text-indigo-600 dark:bg-indigo-500/10 dark:text-indigo-300">
                                            <svg viewBox="0 0 24 24" class="size-7" fill="none" stroke="currentColor" stroke-width="1.7" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 18V5l12-2v13" />
                                                <circle cx="6" cy="18" r="3" />
                                                <circle cx="18" cy="16" r="3" />
                                            </svg>
                                        </div>
                                        <p class="mt-4 font-bold text-slate-700 dark:text-slate-200">لا توجد أغانٍ في القائمة بعد</p>
                                        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">ستظهر النغمات المتاحة هنا عند إضافتها.</p>
                                    </td>
                                </tr>
                            {/each}
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col gap-2 border-t border-slate-100 px-5 py-4 text-xs text-slate-500 dark:border-white/5 dark:text-slate-400 sm:flex-row sm:items-center sm:justify-between">
                    <p>إرسال <span class="mx-1 rounded bg-slate-100 px-1.5 py-0.5 font-mono font-bold text-slate-700 dark:bg-white/10 dark:text-slate-200">رمز الأغنية</span> إلى <span class="font-mono font-bold text-indigo-600 dark:text-indigo-300">1717</span> ثم قم بإرسال الرسالة</p>
                    <p>يمكنك الاستماع إلى المقطع قبل اختيار نغمتك</p>
                </div>
            </div>
        </section>

        <footer class="mt-12 flex flex-col gap-3 border-t border-slate-200 pt-6 text-xs text-slate-500 dark:border-white/10 dark:text-slate-400 sm:flex-row sm:items-center sm:justify-between">
            <p>Ring Back Tone — اجعل كل اتصال يعبر عن شخصيتك</p>
            <a href="#top" class="font-bold text-indigo-600 hover:text-indigo-500 dark:text-indigo-300">العودة إلى الأعلى ↑</a>
        </footer>
    </main>

    <audio bind:this={audioPlayer} onended={handlePlaybackEnded} onerror={handlePlaybackError} class="hidden"></audio>
</div>
