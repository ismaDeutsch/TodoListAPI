<template>
  <div class="container mt-4">
    <table class="table">
      <thead>
        <tr>
          <th>Fait</th>
          <th>Tache</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(item, index) in items" :key="index">
          <item :item="item" v-on:itemChanged="$emit('reloadItem')" />
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import Item from "./Item.vue";
export default {
  props: {
    items: {
      type: Array,
    },
  },
  components: {
    Item,
  },
};
</script>

<style scoped>
.item {
  background: #e6e6e6;
  padding: 5px;
}
</style>