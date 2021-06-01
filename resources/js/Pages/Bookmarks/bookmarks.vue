<template>
    <app-layout>
        <div class="container mx-auto md:px-12 p-5">

            <div v-if="this.bookmarks.length==0"
                class="text-blue-900 px-6 py-4 rounded relative bg-gray-200 max-w-7xl mx-auto">
                <span class="inline-block align-middle mr-8">
                    لا توجد أي إشارات مرجعية بعد.
                </span>
            </div>

            
                <div v-else v-for="place in this.bookmarks" :key="place.id" class="flex mt-5 bg-white border">
                    <div class="flex-none w-48 relative">
                        <img :src="$page.props.asset + place.image" alt="" class="absolute inset-0 w-full h-full object-cover" />
                    </div>
                    <div class="flex-auto p-6">
                        <div class="flex flex-wrap">
                            <h1 class="flex-auto text-xl font-semibold">
                                {{ place.name }}
                            </h1>
                            <div class="w-full flex-none text-sm font-medium text-gray-500 mt-2">
                                {{ place.address }}
                            </div>
                        </div>
                        <div class="flex space-x-3 mb-4 text-sm font-medium mt-5">
                            <div class="flex-auto flex space-x-3">
                                <inertia-link :href="route('places.show', place.id) "
                                    class="w-15 h-8 flex items-center justify-center rounded-md border border-gray-300">عرض</inertia-link>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </app-layout>
</template>
<script>
    import AppLayout from "@/Layouts/AppLayout";
    export default {
        components: {AppLayout},
        props: ['bookmarks']
    }

</script>
