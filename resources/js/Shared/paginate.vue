<template>
    <nav aria-label="Page navigation example">
        <ul class="pagination">
            <li class="page-item" :class="[data.prev_page_url===null?['disabled','d-none']:'']">
                <inertia-link class="page-link" :href="data.prev_page_url===null?'':data.prev_page_url" >Previous</inertia-link>
            </li>
            <li v-for="(link,index) in this.links" :key="index" class="page-item" :class="(index+1)==data.current_page?'active':''">
                <inertia-link class="page-link" :href="data.path+'?page='+(index+1)">{{ index+1 }}</inertia-link>
            </li>
            <li class="page-item" :class="[data.next_page_url===null?['disabled','d-none']:'']">
                <inertia-link class="page-link" :href="data.next_page_url===null?'':data.next_page_url">Next</inertia-link>
            </li>
        </ul>
    </nav>
</template>

<script>
    export default {
        props:['data'],
        data(){
            return{
                counter:1,
                links:[],
            }
        },
        created() {
            while (this.counter <= this.data.last_page) {
                this.links.push(this.counter)
                this.counter++;
            }
        }
    }

</script>
