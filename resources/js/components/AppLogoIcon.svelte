<script lang="ts">
    let {
        class: className = "",
        ...rest
    }: {
        class?: string;
        [key: string]: unknown;
    } = $props();
</script>

<svg
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    stroke-width="1.8"
    aria-hidden="true"
>
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M4 13v-2a8 8 0 0 1 16 0v2"
    />
    <path
        stroke-linecap="round"
        stroke-linejoin="round"
        d="M4 13h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-4Zm16 0h-2a2 2 0 0 0-2 2v2a2 2 0 0 0 2 2h1a2 2 0 0 0 2-2v-4Z"
    />
</svg>
