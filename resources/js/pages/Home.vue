<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">Home</div>

          <div class="card-body"><FilterComponent /></div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import FilterComponent from '../components/FilterComponent.vue';
export default {
    components: {
      FilterComponent
    },
}
</script>