<template>
    <div class="flex justify-center w-full">
        <form @submit.prevent="search"  class="w-9/12" autocomplete="off">
            <div class="flex flex-row p-5 w-full">
                <div class="w-6/12">
                    <input @keyup="autoComplete" type="text" name="address" id="address" autocomplete="off" v-model="result.address"
                        class="p-2 w-full bg-gray-200 rounded-md" placeholder="ابحث عن">
                    <transition name="slide-fade">
                        <ul class="bg-gray-100 rounded-b-lg  shadow-xl -mt-0" v-show="output.length>0" >
                            <li v-for="row in output" :key="row.id" class="border-b border-gray-300 flex items-center justify-between px-4 cursor-pointer py-4 hover:bg-gray-400"
                                @click="putText(row)">{{ row.name }}</li>
                        </ul>
                    </transition>

                </div>

                <div class="w-6/12">
                    <select name="category" class="p-2 mr-5 w-full bg-gray-200 rounded-md" v-model="result.category">
                        <option value="">حدد التصنيف</option>
                        <option v-for="cat in $page.props.categories" :key="cat.id" :value="cat.id">
                            {{ cat.title }}
                        </option>
                    </select>
                </div>

                <div class="mr-5">
                    <button type="submit"
                        class="py-2 px-5 bg-gray-500 hover:bg-gray-400 text-white mr-5 rounded-md">ابحث</button>
                </div>
            </div>
        </form>
    </div>
</template>

<script>
    export default {

        data() {
            return {
                result: {
                    address: "",
                    category:null
                },
                output: {},
            } /* return */
        } /* data */ ,

        methods: {
            autoComplete() {
                axios.post('/autocomplete', this.result).then(response => {
                    this.output = response.data;
                });
            },
            putText(row) {
                this.result.address = row.name;
                this.output = {};
            },

            search(){
                this.$inertia.get(route('search'),this.result)
            }
        }
    }

</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
