<template>
    <app-layout>
        <div class="container my-12 mx-auto md:px-12 p-5">
            <h1 class="text-2xl p-5 mb-2">أضف موقعًا </h1>
            <hr class="mb-5" />
            <form class="form-contact" enctype="multipart/form-data" @submit.prevent="submit">

                <div class="grid grid-cols-2 gap-4">
                    <div class="">
                        <label for="name"> اسم الموقع</label>
                        <input type="text"
                            class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                            v-model="form.name" />
                            <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.name">{{form.errors.name}}</div>
                    </div>
                    <div class="">
                        <label for="catg"> اختر التصنيف</label>
                        <select
                            class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                            v-model="form.category_id">
                            <option v-for="cat in $page.props.categories" :key="cat.id" :value="cat.id">
                            {{ cat.title }}
                        </option>
                        </select>
                        <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.category_id">{{form.errors.category_id}}</div>
                    </div>
                </div>
                <div class="">
                    <label for="overview"> نبذة عن الموقع</label>
                    <textarea type="text"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                        v-model="form.overview" id="overview" rows="5"></textarea>
                        <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.overview">{{form.errors.overview}}</div>
                </div>
                <div class="flex mb-4 items-center">
                    <label for="details"> اختر صورة </label>
                    <input type="file" class="form-control" @change="fileAdded()" id="fileinput">
                    <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.image">{{form.errors.image}}</div>
                    <img-preview :file="form.image" :width="150" :height="150" :class="rounded-full" v-if="form.image"></img-preview>
                </div>
                <div class="mt-2">
                    <div id="mapid" style="height: 350px;" @click="selectPlace"></div>
                </div>
                <div class="mt-4">
                    <label for="address1"> العنوان</label>
                    <input type="text"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                        v-model="form.address" id="address1" />
                        <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.address">{{form.errors.address}}</div>
                </div>
                <div class="form-group col-lg-6">
                    <label for="long">خط الطول</label>
                    <input type="text"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                        v-model="form.longitude" />
                        <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.longitude">{{form.errors.longitude}}</div>
                </div>
                <div class="form-group col-lg-6">
                    <label for="lat">خط العرض</label>
                    <input type="text"
                        class="w-full mt-2 mb-6 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                        v-model="form.latitude" />
                        <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.latitude">{{form.errors.latitude}}</div>
                </div>
                <button type="submit"
                    class="mt-3 bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">إرسال</button>
            </form>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import imgPreview from "@/Shared/imgPreview";
import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
            AppLayout,
            imgPreview
        },

        data() {

            return {
                
                mymap: null,
                src: "",
                form: Inertia.form({
                    name: "",
                    category_id: '',
                    overview: "",
                    latitude: '',
                    longitude: '',
                    address: "",
                    image:''
                })
            }
        },
        methods: {
            submit() {
                this.form.post(route('places.store'),{
                    preserveScroll: true,
                    onSuccess: () => {
                        new Noty({
                            theme: 'metroui',
                            type: 'success',
                            layout: 'topRight',
                            text: 'تم إضافة الموقع بنجاح',
                            timeout: 2000,
                            killer: true
                        }).show()
                    this.form.reset()
                    },
                    onError:()=>new Noty({
                            theme: 'metroui',
                            type: 'error',
                            layout: 'topRight',
                            text: 'هناك بعض الأخطاء الرجاء المحاولة مرة أخرى',
                            timeout: 2000,
                            killer: true
                        }).show()
                })
            },
            fileAdded() {
                const input = document.getElementById('fileinput');
                this.form.image = input.files[0];
            },
        },

        mounted() {

            var app = this;
            this.mymap = L.map('mapid').setView([21.422510, 39.826168], 13);
            var map = this.mymap;
            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);
            map.locate({
                setView: true,
                maxZoom: 10
            });
            map.on('locationfound', function (e) {
                L.marker(e.latlng).addTo(map);
            });
            map.on('locationerror', function (e) {
                alert(e.message);
            });

            var geocodeService = L.esri.Geocoding.geocodeService();
            map.on('mousedown', function (e) {
                app.form.longitude = e.latlng.lng;
                app.form.latitude = e.latlng.lat;
                geocodeService.reverse().latlng(e.latlng).run(function (error, result) {
                    if (error) {
                        return;
                    }
                    app.form.address = result.address.Match_addr;
                    L.marker(result.latlng).addTo(map).bindPopup(result.address.Match_addr).openPopup();
                })
            })
        }
    }

</script>
