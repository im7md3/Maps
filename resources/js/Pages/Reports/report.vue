<template>
    <app-layout>
        <div v-if="$page.props.user" class="container my-12 mx-auto md:px-12 bg-white p-5 border">
            <form @submit.prevent="submit">

                <h4 class="mb-4 mt-4">بلغ عن موقع</h4>
                <hr />
                <div class="mt-4">
                    <input type='text'
                        class="w-full mt-4  px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                        v-model="form.place_url" id="place_url" name="place_url" readonly />
                        <div class=" text-red-500 mb-6 w-full" v-if="form.errors.place_url">{{form.errors.place_url}}</div>
                </div>
                <div class="">
                    <input type='text'
                        class="w-full mt-4  px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                        placeholder="اسمك" name="name" v-model="form.name"/>
                        <div class=" text-red-500 mb-6 w-full" v-if="form.errors.name">{{form.errors.name}}</div>
                </div>
                <div class="">
                    <input type='text'
                        class="w-full mt-4 px-4 py-2 border rounded-lg text-gray-700 focus:outline-none focus:border-blue-400"
                        placeholder="البريد الإلكتروني" name="email" v-model="form.email"/>
                        <div class=" text-red-500 mb-6  w-full" v-if="form.errors.email">{{form.errors.email}}</div>
                </div>
                <br>
                <input type="submit" id=""
                    class="mt-3 bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none"
                    value="إبلاغ">

                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
  {{ form.progress.percentage }}%
</progress>
            </form>
        </div>

        <div v-else class="container p-5 bg-red-500 text-white text-center mx-auto my-5 shadow-lg">
            يجب تسجيل الدخول أولا
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import { Inertia } from '@inertiajs/inertia'

    export default {
        components: {
            AppLayout
        },
        data() {
            return {
                form:Inertia.form ({
                    place_url:this.$page.props.prevUrl,
                    name:"",
                    email:""
                })
            }
        },
        methods:{
            submit(){
                this.form.post(route('reports.store'),{
                    preserveScroll: true,
                    onSuccess: () => {
                        new Noty({
                            theme: 'metroui',
                            type: 'success',
                            layout: 'topRight',
                            text: 'تم تسجيل البلاغ بنجاح',
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
            }
        }
    }

</script>
