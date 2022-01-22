<template>
  <div class="jumbotron mt-5">
    <div class="container">
      <b-button variant="danger" v-if="this.todo" @click="removeTodoList">
        Supprimer la TodList
      </b-button>
      <b-button variant="primary" v-else @click="addTodoList"
        >Ajouter une TodoList</b-button
      >
      <div v-if="this.todo">
        <todo-list />
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import TodoList from "./TodoList.vue";

export default {
  name: "App",
  components: { TodoList },
  data: () => {
    return {
      todo: null,
    };
  },

  methods: {
    addTodoList() {
      axios
        .post("http://127.0.0.1:8000/api/todolist")
        .then((res) => {
          if (res.status == 201) this.todo = true;
        })
        .catch((error) => {
          console.log(error);
        });
    },

    removeTodoList() {
      axios
        .delete("http://127.0.0.1:8000/api/todolist")
        .then((res) => {
          if (res.status == 204) this.todo = false;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },

  beforeCreate() {
    axios
      .get("http://127.0.0.1:8000/api/todolist")
      .then((res) => {
        if (res.status == 200)
          if (res.data.length > 0) this.todo = true;
          else this.todo = false;
      })
      .catch((error) => {
        console.log(error);
      });
  },
};
</script>

<style scoped>
</style>
