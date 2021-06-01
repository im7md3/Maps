<template>
<section class="m-auto text-center">
    <div class="category mt-5">
    <ul>
        <li v-for="cat in $page.props.categories" :key="cat.id">
            <inertia-link :href="route('categories.show',cat)" class="bg-blue-900 hover:bg-gray-400">{{__(cat.title)}}</inertia-link>
        </li>
    </ul>
</div>
</section>
    
</template>

<style scoped>
.category ul li {
    display: inline-block;
    margin-bottom: 5px;
}

.category ul li a {
    border: none;
    border-radius: 5px;
    font-size: 14px;
    color: #fff;
    font-weight: #000;
    padding: 5px 19px;
    display: inline-block;
    margin: 0 3px;
    -webkit-transition: 0.3s;
    -moz-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
    cursor: pointer;
}
</style>
