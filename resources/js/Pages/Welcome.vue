<template>
    <app-layout>
        <div class="container my-12 mx-auto px-4">
            <div class="flex flex-wrap -mx-1 lg:-mx-4">
                <div class="my-1 px-1 w-full md:w-1/2 lg:my-4 lg:px-4 lg:w-1/3" v-for="place in places" :key="place.id">
                <article class="overflow-hidden rounded-lg shadow-lg bg-white">
                    <inertia-link :href="route('places.show',place.id)">
                        <img alt="Placeholder" class="block h-96 w-full" :src="$page.props.asset+place.image">
                    </inertia-link>
                    <header class="items-center justify-between leading-tight p-2 md:p-4">
                        <h1 class="text-base mb-3">
                            <inertia-link class="no-underline hover:underline text-black" :href="route('places.show',place.id)">
                                {{ place.name }}
                            </inertia-link>
                        </h1>
                        <h4 class="text-xs"> {{ place.address }}</h4>
                    </header>
                </article>
            </div>  
            </div>
        </div>
    </app-layout>

</template>

<script>
    import AppLayout from '@/Layouts/AppLayout'
    import Welcome from '@/Jetstream/Welcome'

    export default {
        components: {
            AppLayout,
            Welcome,
        },
        props: {
            canLogin: Boolean,
            canRegister: Boolean,
            laravelVersion: String,
            phpVersion: String,
            places: Object,
        },
        methods:{
            
        }
    }

</script>
