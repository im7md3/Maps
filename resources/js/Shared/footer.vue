<template>
    <div class="p-5 flex items-center justify-center bg-indigo-900  border-gray-100">
        <inertia-link href="/">
            <jet-application-mark class="block h-9 w-auto" />
        </inertia-link>
    </div>
</template>

<script>
    import JetApplicationMark from '@/Jetstream/ApplicationMark'

    export default {
        components: {
            JetApplicationMark,
        }
    }

</script>
