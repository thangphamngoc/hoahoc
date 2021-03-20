<template>
  <transition name="dialog">
    <div v-if="active" class="dialog-backdrop">
      <div class="dialog-container" @click.stop>
        <div class="d-flex justify-content-between">
          <h3>Ảnh</h3>
          <button
            type="button"
            class="btn btn-danger"
            @click="handleBackdropClick"
          >
            Close
          </button>
        </div>
        <hr />
        <div class="d-flex">
        <!-- <div  v-if="images.length == 1">
            <img v-bind:src="images" alt="ảnh đại diện fb" style="width: 15.5rem;"/>
        </div> -->
        <div  v-for="(item, key) in images " class="item-image">
            <img v-bind:src="item" alt="ảnh đại diện fb" style="width: 15.5rem;"/>
        </div>
      </div>
      </div>
    </div>
  </transition>
</template>

<script>
const config = {
  headers: { "content-type": "multipart/form-data" },
};
export default {
  name: "addNick",
  props: {
    active: { type: Boolean, default: false },
  },
  data() {
    return {
      images: [],
    };
  },
  methods: {
    handleBackdropClick() {
      this.$emit("update:active", false);
      this.closeDialog();
      this.update = false;
    },
    closeDialog() {
      this.images = "";
    },
    getData(data){
      if(Array.isArray(data)){
        this.images = data;
      }else{
        this.images.push(data);
      }
    }
  },
};
</script>

<style scoped>
.item-image{
  margin: 0 10px 0 0px  ;
}
.remove-button {
  position: absolute;
  bottom: 19px;
  left: 15px;
  margin-bottom: -1px;
}
.button-submit {
  margin: 10px 0;
  padding: 0;
}
.custom-file {
  padding: 2px;
}
.dialog-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.5);
}

.dialog-container {
  max-width: 70%;
  box-shadow: 0 11px 15px -7px rgba(0, 0, 0, 0.2),
    0 24px 38px 3px rgba(0, 0, 0, 0.14), 0 9px 46px 8px rgba(0, 0, 0, 0.12);
  margin-top: 30px;
  margin-left: auto;
  margin-right: auto;
  padding: 15px;
  background-color: #fff;
}

.dialog-enter-active,
.dialog-leave-active {
  transition: opacity 0.2s;
}
.dialog-enter,
.dialog-leave-to {
  opacity: 0;
}

.dialog-enter-active .dialog-container,
.dialog-leave-active .dialog-container {
  transition: transform 0.4s;
}
.dialog-enter .dialog-container,
.dialog-leave-to .dialog-container {
  transform: scale(0.9);
}
</style>