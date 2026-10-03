<script module lang="ts">
    export const layout = {
        breadcrumbs: [
            {
                title: "Dashboard",
                href: dashboardIndex(),
            },
            {
                title: "Songs Create",
                href: dashboardCreate(),
            },
        ],
    };
</script>

<script lang="ts">
    import { index as dashboardIndex } from "@/routes/dashboard";
    import { create as dashboardCreate } from "@/routes/dashboard";
    import { store as dashboardStore } from "@/routes/dashboard";

    import { Form, page } from "@inertiajs/svelte";
    import AppHead from "@/components/AppHead.svelte";
    import { Button } from "@/components/ui/button";
    import InputError from "@/components/InputError.svelte";
    import { Input } from "@/components/ui/input";
    import { Label } from "@/components/ui/label";
    import { Spinner } from "@/components/ui/spinner";
    import { Link } from "@inertiajs/svelte";
    import { toUrl } from "@/lib/utils";
    let { artists, sims } = $props();
    // Access options passed from your Laravel Controller
    // $: artists = $page.props.artists || [];
    // $: sims = $page.props.sims || [];
</script>

<AppHead title="إضافة أغنية جديدة" />

<div class="flex h-full flex-1 flex-col gap-4 p-4 md:p-6" dir="rtl">
    <div
        class="relative flex-1 rounded-xl border border-sidebar-border/70 bg-white dark:bg-zinc-900 shadow-sm"
    >
        <!-- Header -->
        <div
            class="p-6 border-b border-sidebar-border/70 flex items-center justify-between"
        >
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                    إضافة أغنية جديدة
                </h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                    أدخل تفاصيل الأغنية الجديدة لإضافتها إلى النظام.
                </p>
            </div>
            <Link
                href={toUrl(dashboardIndex())}
                class="inline-flex items-center bg-blue-600 text-white px-4 py-2 rounded"
            >
                العودة للقائمة
            </Link>
        </div>

        <!-- Form Body -->
        <div class="p-6 max-w-2xl mx-auto">
            <Form
                action={toUrl(dashboardStore())}
                method="post"
                class="space-y-6"
            >
                {#snippet children({ errors, processing })}
                    <!-- Artist Dropdown -->
                    <div class="grid gap-2">
                        <Label
                            for="artist_id"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            الفنان
                            <span class="text-red-500">*</span>
                        </Label>
                        <select
                            id="artist_id"
                            name="artist_id"
                            required
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-right"
                        >
                            <option value="" disabled selected
                                >اختر الفنان...</option
                            >
                            {#each artists as artist}
                                <option value={artist.id}>{artist.name}</option>
                            {/each}
                        </select>
                        <InputError message={errors.artist_id} />
                    </div>

                    <!-- SIM Dropdown -->
                    <div class="grid gap-2">
                        <Label
                            for="sim_id"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            مزود الخدمة / الشرائح (SIM)
                            <span class="text-red-500">*</span>
                        </Label>
                        <select
                            id="sim_id"
                            name="sim_id"
                            required
                            class="flex h-10 w-full rounded-md border border-input bg-background px-3 py-2 text-sm ring-offset-background file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-muted-foreground focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 text-right"
                        >
                            <option value="" disabled selected
                                >اختر الشريحة...</option
                            >
                            {#each sims as sim}
                                <option value={sim.id}>{sim.name}</option>
                            {/each}
                        </select>
                        <InputError message={errors.sim_id} />
                    </div>

                    <!-- Song Title -->
                    <div class="grid gap-2">
                        <Label
                            for="title"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            عنوان الأغنية
                            <span class="text-red-500">*</span>
                        </Label>
                        <Input
                            id="title"
                            type="text"
                            name="title"
                            required
                            autocomplete="off"
                            placeholder="أدخل عنوان الأغنية"
                            class="text-right"
                        />
                        <InputError message={errors.title} />
                    </div>

                    <!-- Song Number -->
                    <div class="grid gap-2">
                        <Label
                            for="song_no"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            رقم الأغنية
                            <span class="text-red-500">*</span>
                        </Label>
                        <Input
                            id="song_no"
                            type="text"
                            name="song_no"
                            required
                            placeholder="أدخل رقم الأغنية الفريد"
                            class="text-right"
                        />
                        <InputError message={errors.song_no} />
                    </div>

                    <!-- Link -->
                    <div class="grid gap-2">
                        <Label
                            for="link"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            رابط الأغنية
                            <span class="text-red-500">*</span>
                        </Label>
                        <Input
                            id="link"
                            type="text"
                            name="link"
                            required
                            placeholder="أدخل رابط الأغنية"
                            class="text-right"
                        />
                        <InputError message={errors.link} />
                    </div>

                    <!-- subscription_detail -->
                    <div class="grid gap-2">
                        <Label
                            for="subscription_detail"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            تفاصيل الاشتراك
                            <span class="text-red-500">*</span>
                        </Label>
                        <Input
                            id="subscription_detail"
                            type="text"
                            name="subscription_detail"
                            required
                            placeholder="أدخل تفاصيل الاشتراك"
                            class="text-right"
                        />
                        <InputError message={errors.subscription_detail} />
                    </div>

                    <!-- fast_subscription -->
                    <div class="grid gap-2">
                        <Label
                            for="fast_subscription"
                            class="font-semibold text-gray-700 dark:text-gray-200"
                        >
                            اشتراك سريع
                            <span class="text-red-500">*</span>
                        </Label>
                        <Input
                            id="fast_subscription"
                            type="text"
                            name="fast_subscription"
                            required
                            placeholder="أدخل اشتراك سريع"
                            class="text-right"
                        />
                        <InputError message={errors.fast_subscription} />
                    </div>

                    <fieldset class="grid w-full max-w-xs gap-3">
                        <legend class="text-sm font-medium">
                            حالة الأغنية
                        </legend>
                        <!-- <p class="text-sm text-muted-foreground">
                            Yearly and lifetime plans offer significant savings.
                        </p> -->
                        <label class="flex items-center gap-2 font-normal">
                            <input
                                type="radio"
                                name="is_active"
                                value="1"
                                checked
                            />
                            مفعل (متاح)
                        </label>
                        <label class="flex items-center gap-2 font-normal">
                            <input
                                type="radio"
                                name="is_active"
                                value="0"
                            />
                            غير مفعل (غير متاح)
                        </label>
                    </fieldset>

                    <!-- Actions -->
                    <div
                        class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100 dark:border-zinc-800"
                    >
                        <Link href={toUrl(dashboardIndex())}>
                            <Button
                                class="cursor-pointer"
                                type="button"
                                variant="ghost"
                                disabled={processing}
                            >
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
                            حفظ الأغنية
                        </Button>
                    </div>
                {/snippet}
            </Form>
        </div>
    </div>
</div>
