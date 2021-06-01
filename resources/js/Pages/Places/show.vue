<template>
    <app-layout>
        <div class="py-12">
            <div class="text-center mt-5 p-5">
                <h1 class="text-2xl mb-2">{{ place[0].name }}</h1>
                <small>{{ place[0].address }}</small>

            </div>


            <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-5 mt-5">
                <div class="col-span-2 bg-white shadow-lg rounded p-5">
                    <div class="">
                        <h1 class="mb-4 text-2xl">نبذة عن الموقع</h1>
                        <p class="text-sm">{{ place[0].overview }}</p>
                    </div>
                    <div class="mt-5 ">
                        <h3 class="mb-4 text-2xl">الموقع</h3>
                        <div id="mapid" style="height: 350px;"></div>
                        <input id="name" type="hidden" :value=" place[0].name ">
                        <input id="latitude" type="hidden" :value="place[0].latitude">
                        <input id="longitude" type="hidden" :value=" place[0].longitude ">
                    </div>
                </div>

                <div class="bg-white shadow-lg rounded p-4 h-52">
                    <div class="p-5 bg-white shadow-sm">
                        <h3>{{ place[0].user.name }}</h3>
                        <p></p>
                        <ul class="mt-3">
                            <li><i class="ml-1 fa fa-envelope"></i>{{ place[0].user.email }} </li>
                        </ul>
                    </div>
                    <hr/>
                    <div v-show="$page.props.user" class="p-3">
                        <transition name="fade" mode="out-in">
                            <button v-if="isMark(place[0].id)"  @click="toggleMark(place[0])" class="border border-blue-600 text-xs text-white bg-blue-600  rounded ml-3 p-1 focus:outline-none" :class="{ textWhite: isMark(place[0]) }">
                                <i class="ml-1 fas fa-bookmark "></i>
                                علامة مرجعية
                            </button>

                            <button v-else @click="toggleMark(place[0])" class="border border-blue-600 text-xs text-blue-600 rounded ml-3 p-1 focus:outline-none" >
                                <i class="ml-1 fas fa-bookmark"></i>
                                علامة مرجعية
                            </button>
                        </transition>
                        <inertia-link :href="route('reports.create')" 
                            class="border border-red-500 text-xs text-red-500 hover:bg-red-500 hover:text-gray-200 rounded p-1 focus:outline-none">
                            <i class="ml-1 fas fa-exclamation-triangle"></i>إبلاغ موقع مكرر
                        </inertia-link>

                    </div>
                </div>

                <div class="bg-white col-span-2 shadow-lg rounded p-5 grid grid-cols-1 lg:grid-cols-3">
                    <div class="text-center v_line">
                        <h1>
                            {{ Math.round(total*10)/10 }}
                        </h1>
                        <div class="rating">
                            <h3>

                            </h3>
                        </div>
                        <div>
                            <span>عدد التقييمات</span> {{ place[0].reviews_count }}
                        </div>
                    </div>
                    <div class="mr-2 col-span-2">
                        <div class="text-right">
                            <span class=""></span>الخدمة
                        </div>
                        <div class="text-right">
                            <progress :value="service_rating" class="w-full" max="5"
                                :title="Math.round(service_rating*10)/10"></progress>
                        </div>

                        <div class="text-right">
                            <span class=""></span>الجودة
                        </div>
                        <div class="text-right">
                            <progress :value="quality_rating" class="w-full" max="5"
                                :title="Math.round(quality_rating*10)/10"></progress>
                        </div>

                        <div class="text-right">
                            <span class=""></span>النظافة
                        </div>
                        <div class="">
                            <progress :value="cleanliness_rating" class="w-full" max="5"
                                :title="Math.round(cleanliness_rating*10)/10"></progress>
                        </div>

                        <div class="text-right">
                            <span class=""></span>السعر
                        </div>
                        <div class="">
                            <progress :value="pricing_rating" class="w-full" max="5"
                                :title="Math.round(pricing_rating*10)/10"></progress>
                        </div>

                    </div>

                </div>
                <div class="bg-white col-span-2 shadow-lg rounded p-5" v-if="reviews.data.length>0">

                    <div v-for="review in reviews.data" :key="review.id" class="row text-right bg-white p-4 shadow-sm" id="reviews">
                        <div class="review-block ">
                            <div class="grid grid-cols-3 p-5">
                                <div class="text-sm">
                                    <img src="http://dummyimage.com/60x60/666/ffffff&text=No+Image" class="img-rounded">
                                    <div class="text-blue-400"><a href="#"> {{ review.user.name }} </a></div>
                                    <div class="review-block-date"> {{ review.created_at }}</div>
                                </div>
                                <div class="col-span-2">

                                    <div class="rating">
                                        <span v-for="item in 5" :key="item" :title="avgRating(review)">
                                            <i v-if="item <= avgRating(review)" class="fa fa-star"
                                                aria-hidden="true"></i>
                                            <i v-else-if="item == Math.round(avgRating(review))"
                                                class="fas fa-star-half-alt fa-flip-horizontal"></i>
                                            <i v-else class="far fa-star" aria-hidden="true"></i>
                                        </span>
                                    </div>
                                    <div class="review-block-description ">{{ review.review }}</div>
                                    <div class="mt-3">
                                        <button v-if="$page.props.user" id="like" type="button"
                                            class="border rounded p-1 text-xs like shadow-md like"
                                            @click="toggleLike(review)">
                                            <transition name="fade" mode="out-in">
                                                <span v-if="isLiked(review.id)" title="إلغاء الإعجاب">
                                                    <i
                                                        class="fas fa-heart text-2xl text-red-600 hover:text-red-900"></i>

                                                </span>
                                                <span v-else title="إعجاب">
                                                    <i
                                                        class="far fa-heart text-2xl text-gray-600 hover:text-red-900"></i>
                                                </span>
                                            </transition>
                                            <span class="mr-2">{{ review.likes_count }}</span>
                                        </button>
                                        <button v-else class="border rounded p-1 text-xs like shadow-md like"><i
                                                class="fas fa-heart text-2xl text-red-600"></i>
                                            <span class="mr-2">{{ review.likes_count }}</span></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                    </div>
                    <paginate v-if="reviews.data.length>0" :data="reviews"></paginate>

                </div>

                <div v-if="$page.props.user" id="review-div" class="bg-white col-span-2 shadow-lg rounded p-5">
                    <h3 class="mb-4 mt-3">أضف مراجعة</h3>
                    <hr />
                    <form class="form-contact" @submit.prevent="submitReview">
                        <div class="grid grid-cols-2 mt-5">
                            <div class="">
                                <div class="rating float-right">
                                    <h5>الخدمة</h5>
                                    <input type="radio" id="rating_service1" value="5"
                                        v-model="form.service_rating" /><label for="rating_service1"
                                        title="ممتاز"></label>
                                    <input type="radio" id="rating_service2" value="4"
                                        v-model="form.service_rating" /><label for="rating_service2"
                                        title="جيد جدًا"></label>
                                    <input type="radio" id="rating_service3" value="3"
                                        v-model="form.service_rating" /><label for="rating_service3"
                                        title="متوسط"></label>
                                    <input type="radio" id="rating_service4" value="2"
                                        v-model="form.service_rating" /><label for="rating_service4"
                                        title="سيء"></label>
                                    <input type="radio" id="rating_service5" value="1"
                                        v-model="form.service_rating" /><label for="rating_service5"
                                        title="سيء للغاية"></label>
                                </div>
                            </div>
                            <div class="">
                                <div class="rating float-right">
                                    <h5>الجودة</h5>
                                    <input type="radio" id="rating_quality1" value="5"
                                        v-model="form.quality_rating" /><label for="rating_quality1"
                                        title="ممتاز"></label>
                                    <input type="radio" id="rating_quality2" value="4"
                                        v-model="form.quality_rating" /><label for="rating_quality2"
                                        title="جيد جدًا"></label>
                                    <input type="radio" id="rating_quality3" value="3"
                                        v-model="form.quality_rating" /><label for="rating_quality3"
                                        title="متوسط"></label>
                                    <input type="radio" id="rating_quality4" value="2"
                                        v-model="form.quality_rating" /><label for="rating_quality4"
                                        title="سيء"></label>
                                    <input type="radio" id="rating_quality5" value="1"
                                        v-model="form.quality_rating" /><label for="rating_quality5"
                                        title="سيء للغاية"></label>
                                </div>
                            </div>
                        </div>
                        <div class="grid grid-cols-2">
                            <div class="">
                                <div class="rating float-right">
                                    <h5>النظافة</h5>
                                    <input type="radio" id="rating_cleanliness1" value="5"
                                        v-model="form.clean_rating" /><label for="rating_cleanliness1"
                                        title="ممتاز"></label>
                                    <input type="radio" id="rating_cleanliness2" value="4"
                                        v-model="form.clean_rating" /><label for="rating_cleanliness2"
                                        title="جيد جدًا"></label>
                                    <input type="radio" id="rating_cleanliness3" value="3"
                                        v-model="form.clean_rating" /><label for="rating_cleanliness3"
                                        title="متوسط"></label>
                                    <input type="radio" id="rating_cleanliness4" value="2"
                                        v-model="form.clean_rating" /><label for="rating_cleanliness4"
                                        title="سيء"></label>
                                    <input type="radio" id="rating_cleanliness5" value="1"
                                        v-model="form.clean_rating" /><label for="rating_cleanliness5"
                                        title="سيء للغاية"></label>
                                </div>
                            </div>
                            <div class="">
                                <div class="rating float-right">
                                    <h5>السعر</h5>
                                    <input type="radio" id="rating_price1" value="5"
                                        v-model="form.price_rating" /><label for="rating_price1" title="ممتاز"></label>
                                    <input type="radio" id="rating_price2" value="4"
                                        v-model="form.price_rating" /><label for="rating_price2"
                                        title="جيد جدًا"></label>
                                    <input type="radio" id="rating_price3" value="3"
                                        v-model="form.price_rating" /><label for="rating_price3" title="متوسط"></label>
                                    <input type="radio" id="rating_price4" value="2"
                                        v-model="form.price_rating" /><label for="rating_price4" title="سيء"></label>
                                    <input type="radio" id="rating_price5" value="1"
                                        v-model="form.price_rating" /><label for="rating_price5"
                                        title="سيء للغاية"></label>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <div class="form-group">
                                <textarea class="border w-full" name="review" id="review" cols="30" rows="9"
                                    v-model="form.review"></textarea>
                                    
                                    <div class="p-2 my-0.5 bg-red-400 text-white w-full text-center" v-if="form.errors.review">{{form.errors.review}}</div>
                                    
                            </div>

                            <input class="form-control" id="place_id" type="hidden" v-model="form.place_id">
                            <button type="submit"
                                class="mt-3 bg-blue-600 text-gray-200 rounded hover:bg-blue-500 px-4 py-2 focus:outline-none">إرسال</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </app-layout>
</template>

<script>
    import AppLayout from "@/Layouts/AppLayout";
    import paginate from "@/Shared/paginate";
    import { Inertia } from '@inertiajs/inertia'
    export default {
        props: {
            place: Object,
            total: Number,
            service_rating: Number,
            quality_rating: Number,
            cleanliness_rating: Number,
            pricing_rating: Number,
            reviews: Object,
            myuser: Object,
        },
        data() {
            return {
                newLikes: '',
                newMark: '',
                i: 1,
                form: Inertia.form({
                    review: "",
                    place_id: this.place[0].id,
                    service_rating: "",
                    quality_rating: "",
                    clean_rating: "",
                    price_rating: ""
                })
            }
        },
        components: {
            AppLayout,
            paginate
        },
        methods: {
            avgRating(review) {
                return (review.service_rating + review.clean_rating + review.quality_rating + review.price_rating) / 4;
            },
            submitReview() {
                this.form.post(route("reviews.store"),{
                    preserveScroll: true,
                    onSuccess: (res) => {
                        if(this.$page.props.flash.isStored=='false'){
                            new Noty({
                            theme: 'metroui',
                            type: 'error',
                            layout: 'topRight',
                            text: 'لقد قمت بتسجيل مراجعة مسبقا',
                            timeout: 2000,
                            killer: true
                        }).show()
                        }else{
                        new Noty({
                            theme: 'metroui',
                            type: 'success',
                            layout: 'topRight',
                            text: 'تم تسجيل المراجعة بنجاح',
                            timeout: 2000,
                            killer: true
                        }).show()
                    }
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

            isLiked(id) {
                if (this.newLikes.length > 0) {
                    for (var i = 0; i < this.newLikes.length; i++) {
                        if (id == this.newLikes[i].pivot['review_id']) {
                            return true
                        }
                    }
                }
                return false;
            },

            toggleLike(review) {
                this.$inertia.post(route('like'),
                     {
                        'review_id': review.id,
                        'user_id': review.user_id
                    },

                    {
                    preserveScroll: true,
                    onSuccess:()=>{
                        if(this.$page.props.flash.youCant){
                            new Noty({
                            theme: 'metroui',
                            type: 'error',
                            layout: 'topRight',
                            text: this.$page.props.flash.youCant,
                            timeout: 2000,
                            killer: true
                        }).show()
                        }
                    }
            
            })},

            isMark(id) {
                if (this.newMark.length > 0) {
                    for (var i = 0; i < this.newMark.length; i++) {
                        if (id == this.newMark[i].pivot['place_id']) {
                            return true
                        }
                    }
                }
                return false;
            },
            toggleMark(place) {
                axios.post(route('bookmark'), {
                    'place': place.id
                }).then((res) => {
                    this.newMark = res.data.data;
                    this.isMark(review.id)
                })
            },
        },
        updated(){
            if(this.$page.props.user){
                this.newLikes=this.myuser[0].likes
                this.newMark=this.myuser[0].bookmarks
            }
            
        },
        mounted() {
            if(this.$page.props.user){
                this.newLikes=this.myuser[0].likes
                this.newMark=this.myuser[0].bookmarks
            }
            
            var map = L.map('mapid', {
                center: [this.place[0].latitude, this.place[0].longitude],
                zoom: 10
            });

            L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png').addTo(map);

            L.marker([this.place[0].latitude,this.place[0].longitude]).bindPopup(this.place[0].name).addTo(map)
                .openPopup();

        },
    };

</script>

<style scoped>
    .list-item {
        display: inline-block;
        margin-right: 10px;
    }

    .list-enter-active,
    .list-leave-active {
        transition: all 1s;
    }

    .list-enter,
    .list-leave-to

    /* .list-leave-active below version 2.1.8 */
        {
        opacity: 0;
        transform: translateY(30px);
    }

    .rating {
        color: gold;
    }

    .rating>h5 {
        color: rgb(87, 83, 83);
    }

    .rating:not(:checked)>input {
        display: none;
        cursor: pointer;
    }

    .rating:not(:checked)>label:before {
        content: '★';
    }

    .rating:not(:checked)>label {
        float: left;
        cursor: pointer;
        font-size: 160%;
        color: #ddd;
    }

    .rating:not(:checked)>label:hover,
    .rating:not(:checked)>label:hover~label {
        color: gold;
    }

    .rating>input:checked~label {
        color: gold;
    }

    .fade-enter-active,
    .fade-leave-active {
        transition: opacity .5s;
    }

    .fade-enter,
    .fade-leave-to

    /* .fade-leave-active below version 2.1.8 */
        {
        opacity: 0;
    }

    .like {
        outline: none;
    }


</style>
