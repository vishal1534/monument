<template>
    <div class="printing" :id="title" :ref="title">
        <slot name="header"></slot>
        <slot name="body"></slot>
        <slot name="footer"></slot>
    </div>
</template>

<script>
    import {event, eventBus} from "../../event-bus/event-bus";
    export default {
        name: "PdfDownload",
        props: {
            title: {
                type: String,
                default: 'print'
            },
        },
    }
</script>

<style scoped>
    .printing{
        margin: 1rem;
        padding: 1rem;
    }
</style>
