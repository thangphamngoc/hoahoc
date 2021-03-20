<template>
  <transition name="dialog" scrollable>
    <div v-if="active" class="dialog-backdrop">
      <div class="dialog-container" @click.stop>
        <div class="d-flex justify-content-between">
          <h3>Chi tiết bài viết</h3>
          <button
            type="button"
            class="btn btn-danger"
            @click="handleBackdropClick"
          >
            Close
          </button>
        </div>
        <hr />
        <div class="title">
          <label>Tiều đề bài viết</label>
          <input
            v-model="dataCreate.title"
            type="text"
            class="form-control"
            placeholder="Nhập sđt/email/uid"
            required
          />
        </div>
        <div class="content" prop="content">
          <label>Nội dung </label>
          <textarea
            v-model="dataCreate.content"
            class="form-control rounded-0"
            rows="10"
          ></textarea>
        </div>
        <div class="input-group-prepend">
          <p>Ảnh đính kèm</p>
          
        </div>
        <div style="overflow: scroll;" class="d-flex">
        <div v-for="(item, key) in images" :key="key" class="col-sm-3">
            <!-- <img
              v-if="item != ''"
              :src="item"
              class="img-responsive"
              height="100px"
              width="auto"
            /> -->
            <div
              class="circular"
              v-bind:style="{
                backgroundImage: 'url(' + item + ')',
              }"
            ></div>
          </div>
          </div>
        <!-- <img src="url('storage/images/123.png')" alt="123" title="12" /> -->
        <!-- <div class="row col-12">
          <div class="col-md-3" v-for="(item, key) in images" :key="key">
            <img
              v-if="item != ''"
              :src="item"
              class="img-responsive"
              height="100px"
              width="auto"
            />
            <div
              class="circular"
              v-bind:style="{
                backgroundImage: 'url(' + item + ')',
              }"
            ></div>
          </div>
        </div> -->
      </div>
    </div>
  </transition>
</template>

<script>
// const config = {
//   headers: { "content-type": "multipart/form-data" },
// };
export default {
  name: "addNick",
  props: {
    active: { type: Boolean, default: false },
  },
  data() {
    return {
      dataCreate: {
        title: "",
        content: "",
      },
      images: [],
      photos: [],
    };
  },
  methods: {
    handleBackdropClick() {
      this.$emit("update:active", false);
      this.closeDialog();
      this.update = false;
    },
    searchDetail(data) {
      this.dataCreate = data;
      this.update = true;
      // alert(this.dataCreate.status_nick);
    },
    closeDialog() {
      for (var key in this.dataCreate) {
        this.dataCreate[key] = "";
      }
      this.images = [];
      this.photos = [];
    },
    getData(data) {
      this.dataCreate.title = data.postData.title;
      this.dataCreate.content = data.postData.content;
      data.imageList.forEach((element) => {
        this.images.push(element.filename);
      });
    },
  },
  //   mounted() {
  //     let recaptchaScript = document.createElement("script");
  //     recaptchaScript.setAttribute(
  //       "src",
  //       "http://www.shieldui.com/shared/components/latest/js/shieldui-all.min.js"
  //     );
  //     document.head.appendChild(recaptchaScript);
  //   },
  // beforeMount() {
  //   this.searchPropertis();
  // },
};
</script>

<style scoped>
.title,
.content {
  margin-bottom: 10px;
}
.circular {
  width: 100%;
  height: 300px;
  background-repeat: no-repeat;
  background-size: contain;
}

.dialog-backdrop {
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1;
}
.dialog {
  z-index: 2;
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