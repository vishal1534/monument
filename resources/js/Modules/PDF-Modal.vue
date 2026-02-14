<template>
    <div :id="title" :ref="title" class="printing" v-show="printPageDisplay">
        <slot name="printButton">
            <div id="pritnAndCancelPDF" class="position-absolute mt-n4" style="right: 0;">
                <button class="btn-info mx-1  custom-infobtn-toolbar custom-infobtn-text" id="printPreviewPDF" type="button">Print</button>
                <button class="btn btn-sm btn-warning mx-1 px-3 custom-dangerbtn-toolbar custom-dangerbtn-text" id="cancelPreviewPDF" type="button">Cancel</button>
            </div>
        </slot>
        <slot name="header"></slot>
        <slot name="body"></slot>
        <slot name="footer"></slot>
    </div>
</template>

<script>

    import {event, eventBus} from "../event-bus/event-bus";

    export default {
        name: "PDF",
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
            eventBus.$off(event.PRINT_PDF);
        },
        data() {
            return {
                printPageDisplay: false,
            };
        },
        mounted() {
            eventBus.$on(event.PRINT_PDF, this.print);
        },
        methods: {
            print() {
                this.printFormClone();
                window.onafterprint = this.afterPrint;
                document.querySelector("#printPreviewPDF").addEventListener('click', function () {
                    document.querySelector('#pritnAndCancelPDF').remove()
                    window.print()
                });
                document.querySelector('#cancelPreviewPDF').addEventListener('click', this.afterPrint)
                // setTimeout(()=>{window.print()},2000);
            },
            afterPrint() {
                document.querySelector("#" + this.title + "Clone").remove();
                document.querySelector('#app').style.removeProperty('display');
            },
            printFormClone() {
                let app = document.querySelector('#app');
                let print = this.$refs[this.title];
                let printClone = print.cloneNode(true);
                printClone.id = this.title + "Clone";
                printClone.style.display = "block";
                app.before(printClone);
                app.style.display = "none";
            },

        },
    }
</script>


<style scoped>

    .printing {
        margin: 1rem;
        padding: 1rem;
    }

</style>
<style type="text/css" media="print">
/*
TODO:
 this style is added because we need to print table footer only once at the bottom of the page.
 but if you do not use this style then if we have more than one page in pdf then footer will be printed on each page.
 */
    tfoot {
        display: contents;
        width:100%;
    }
</style>
