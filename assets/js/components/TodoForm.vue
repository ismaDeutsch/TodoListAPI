<template>
  <div class="container mt-4">
    <b-form class="form">
      <b-form-input
        type="text"
        v-model="item.title"
        placeholder="Ajouter une tache"
      ></b-form-input>
      <b-button
        :variant="item.title.length > 3 ? 'success' : 'light'"
        @click="addItem()"
        >Ajouter</b-button
      >
    </b-form>
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "TodoForm",
  data: function () {
    return {
      item: {
        title: "",
      },
    };
  },

  methods: {
    addItem() {
      if (this.item.title.length < 3) {
        return;
      }
      axios
        .post("http://127.0.0.1:8000/api/task", {
          title: this.item.title,
        })
        .then((res) => {
          if (res.status == 201) {
            this.item.title = "";
            this.$emit("reloadItem");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
};
</script>

<style scoped>
.form {
  display: flex;
  width: auto;
}
</style>