<template v-slot:modal>
    <div class="modal-mask">
        <div class="modal-wrapper">
        <div class="modal-container">
            <div class="modal-header">
                <slot name="header">
                    Titre de la modale
                </slot>
            </div>
            <div class="modal-body">
                <slot name="body">
                    Contenu de la modale
                </slot>
            </div>
            <div class="modal-footer">
                <slot name="footer">
                    Footer de la modale
                </slot>
            </div>
            <span class="close-icon" @click="$emit('close')">&times;</span>
            <slot></slot>
        </div>
        </div>
    </div>
</template>

<script>
    export default {
    data() {
        return {
        showModal: false
        };
    }
    };
</script>

<style>

    .modal-mask {
    position: fixed;
    z-index: 9998;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: table;
    transition: opacity 0.3s ease;
    }

    .modal-wrapper {
    display: table-cell;
    vertical-align: middle;
    }

    .modal-container {
    width: 500px;
    margin: 0px auto;
    padding: 20px 30px;
    background-color: #fff;
    border-radius: 2px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
    transition: all 0.3s ease;
    font-family: Helvetica, Arial, sans-serif;
    }

    .modal-header {
    margin-bottom: 20px;
    }

    .modal-footer {
    /* margin-top: 20px;
    text-align: right; */
    display: block;
    text-align: center;
    margin-top: 50px;
    }

    .cta-button {
    border: none;
    border-radius: 3em;
    box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.2);
    display: inline-block;
    font-family: 'Old Standard TT', serif;
    font-size: 1em;
    text-decoration: none;
    padding: 1em 2em;
    width: auto;
    }

    .close-icon {
        position: relative;
        bottom: 220px;
        left: 430px;
        cursor: pointer;
        font-size: 30px;
    }


</style>