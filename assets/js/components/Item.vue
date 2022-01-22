<template>
  <fragment>
    <td>
      <b-form-checkbox
        v-model="item.completed"
        @change="updateCheck()"
      ></b-form-checkbox>
    </td>
    <td>
      <label
        v-if="editing !== item.id"
        :class="{ completed: item.completed }"
        >{{ item.title }}</label
      >
      <b-form-input
        v-else
        type="text"
        v-model="item.title"
        @blur="doneEdit(item)"
        @keyup.enter="doneEdit(item)"
        @keyup.esc="cancelEdit(item)"
        v-focus
      />
    </td>
    <td>
      <b-icon icon="pencil-square" @click="editTodo(item)"></b-icon>
      <b-icon variant="danger" icon="trash-fill" @click="removeItem()"></b-icon>
    </td>
  </fragment>
</template>

<script>
import axios from "axios";
export default {
  props: {
    item: {
      type: Object,
    },
  },
  data: () => {
    return {
      beforeEditCache: "",
      editing: null,
    };
  },
  methods: {
    updateCheck() {
      axios
        .patch("http://127.0.0.1:8000/api/task/" + this.item.id, {
          item: this.item,
        })
        .then((res) => {
          if (res.status == 200) {
            this.$emit("itemChanged");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    removeItem() {
      axios
        .delete("http://127.0.0.1:8000/api/task/" + this.item.id)
        .then((res) => {
          if (res.status == 204) {
            this.$emit("itemChanged");
          }
        })
        .catch((error) => {
          console.log(error);
        });
    },
    editTodo(item) {
      this.beforeEditCache = item.title;
      this.editing = item.id;
    },
    doneEdit(item) {
      if (item.title.trim() == "") {
        item.title = this.beforeEditCache;
      } else {
        axios
          .put("http://127.0.0.1:8000/api/task/" + this.item.id, {
            title: this.item.title,
          })
          .then((res) => {
            if (res.status == 200) {
              this.$emit("itemChanged");
            }
          })
          .catch((error) => {
            console.log(error);
          });
      }
      this.editing = null;
    },
    cancelEdit(item) {
      item.title = this.beforeEditCache;
      this.editing = null;
    },
  },
  directives: {
    focus: {
      inserted: (el) => {
        el.focus();
      },
    },
  },
};
</script>

<style scoped>
.completed {
  text-decoration: line-through;
  color: #9999;
}
</style>