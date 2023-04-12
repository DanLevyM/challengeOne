<template><div>
    <b-modal id="modal-details" hide-header>
      <div class="d-block">
        <h1>{{ product.name }}</h1>
        <h3>{{ product.price }}</h3>
      </div>
    </b-modal>
  </div>
</template>
  
<script>
export default {
    name: "ModalDetails",props: {
        user: {
            type: Object,
        },
    },
};
</script>