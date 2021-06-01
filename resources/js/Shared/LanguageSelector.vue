<template>
    <div class="m-2">
        <inertia-link :title="selectable_locale" :href="route('language', [selectable_locale])">
            <icon class="w-5 h-5" :name="selectable_locale" />
        </inertia-link>
    </div>
</template>

<script>
    import Icon from '@/Shared/Icon'

    export default {
        components: {
            Icon,
        },

        computed: {
            selectable_locale() {
                if (this.$page.props.locale === 'ar') {
                    return 'en';
                }else{
                    return 'ar'
                }
            }
        },
    }

</script>
