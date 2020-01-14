<template>

    <div class="modal is-active">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
                <p class="modal-card-title"><slot name="title"></slot></p>
            </header>

            <section class="modal-card-body">

                <slot></slot>

            </section>

            <footer class="modal-card-foot">
                <button class="button  is-success" @click.prevent="$emit('close')">OK</button>
            </footer>
        </div>
    </div>

</template>

<script>

    export default {

        name: 'modal'

    }

</script>