<template>
  <div class="container mt-4">
    <h1 class="mt-2 mb-4">TodoList</h1>
    <todo-form v-on:reloadItem="getItems()" />
    <item-table :items="items" v-on:reloadItem="getItems()" />
  </div>
</template>

<script>
import TodoForm from "./TodoForm.vue";
import ItemTable from "./ItemTable.vue";
import axios from "axios";
export default {
  name: "TodoList",
  components: {
    TodoForm,
    ItemTable,
  },
  data: () => {
    return {
      items: [],
      filter: "all",
    };
  },

  methods: {
    getItems() {
      axios
        .get("http://127.0.0.1:8000/api/task")
        .then((res) => {
          this.items = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  created() {
    this.getItems();
  },
};
</script>

<style scoped>
</style>

