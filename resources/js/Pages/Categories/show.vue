<template>
    <app-layout>

        <div class="py-12">

            <div v-if="this.places.length==0"
                class="text-blue-900 px-6 py-4 rounded relative bg-gray-200 max-w-7xl mx-auto">
                <span class="inline-block align-middle mr-8">
                    لا يوجد مواقع ضمن هذا التصنيف.
                </span>
            </div>

            <div v-else class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-4">

                <div>

                    <div class="flex mb-5 bg-white" v-for="place in places" :key="place.id">

                        <div class="flex-none w-48 relative">
                            <inertia-link :href="route('places.show',place.id)">
                                <img :src="$page.props.asset+place.image" alt=""
                                    class="absolute inset-0 w-full h-full object-cover" />
                            </inertia-link>
                        </div>

                        <div class="flex-auto p-6">

                            <div class="flex flex-wrap">
                                <h1 class="flex-auto text-xl font-semibold">
                                    {{ place.name }}
                                </h1>
                            </div>

                            <div class="flex space-x-3 mb-4 text-sm font-medium mt-5">
                                <div class="flex-auto flex space-x-3">
                                    {{ place.address }}
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="ml-3">
                    <div id="mapid" style="height: 500px; "></div>
                </div>

            </div>

        </div>

    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    export default {
        props: ["places"],
        components: {
            AppLayout,
        },
        mounted() {
            if (this.places.length > 0) {


                var app = this;
                this.mymap = L.map('mapid');
                var map = this.mymap;
                L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

                var markers = [];

                for (var i = 0; i < this.places.length; i++) {
                    markers.push(new L.marker([this.places[i].latitude, this.places[i].longitude]).addTo(map)
                    );
                }

                var group = new L.featureGroup(markers).getBounds();

                map.fitBounds([
                    group
                ]);
            }

        }
    };

</script>
