<template>
    <img id="img" :src="src" :width="width" :height="height" class="rounded-full shadow-lg">
</template>

<script>
    export default {
        data() {
            return {
                src: ''
            }
        },
        props: ['file','width','height','class'],
        methods: {
            loadPicture(file) {
                let self = this;
                let img = document.getElementById('img');
                var reader = new FileReader();
                reader.onload = function (e) {
                    console.log(e);
                    self.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        },
        mounted() {
            this.loadPicture(this.file);
        }
    }

</script>
