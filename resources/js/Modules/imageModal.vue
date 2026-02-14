<template>
    <div class="printing" :id="title" v-show="printPageDisplay" :ref="title">
        <slot name="header"></slot>
        <slot name="body"></slot>
        <slot name="footer"></slot>

    </div>
</template>

<script>

    import {event, eventBus} from "../event-bus/event-bus";

    export default {
        name: "imagePDF",
        props: {
            title: {
                type: String,
                default: 'print'
            },
        },
        created() {
            // eventBus.$on(event.PRINT_PDF, this.print);
        },
        destroyed() {
            eventBus.$off(event.PRINT_IMAGE);
        },
        data(){
            return {
                printPageDisplay: false,
            };
        },
        mounted() {
            eventBus.$on(event.PRINT_IMAGE, this.print);
        },
        methods:{
            print () {;
                this.printFormClone();
                window.onafterprint = this.afterPrint;
                setTimeout(()=>{window.print()},2000);
            },
            afterPrint(){
                document.querySelector("#"+this.title+"Clone").remove();
                document.querySelector('#app').style.removeProperty('display');
            },
            printFormClone(){
                let app = document.querySelector('#app');
                let print = this.$refs[this.title];
                let printClone = print.cloneNode(true);
                printClone.id = this.title+"Clone";
                printClone.style.display = "block";
                app.before(printClone);
                app.style.display = "none";
            }

        },
    }
</script>


<style scoped >

.printing{
    margin: 1rem;
    padding: 1rem;
}

</style>
