<template>
  <transition name="dialog">
    <div v-if="active" class="dialog-backdrop">
      <div class="dialog-container" @click.stop>
        <div class="d-flex justify-content-between">
          <h3 v-if="!update">Thêm bài viết mới</h3>
          <h3>Sửa bài viết</h3>
          <button
            type="button"
            class="btn btn-danger"
            @click="handleBackdropClick"
          >
            Close
          </button>
        </div>
        <hr />
        <form
          class="needs-validation"
          ref="dataCreate"
          :model="dataCreate"
          @submit.prevent="submitForm()"
        >
          <div class="form-row">
            <div class="col-12" prop="title">
              <label>Tiều đề bài viết</label>
              <input
                v-model="dataCreate.title"
                type="text"
                class="form-control"
                placeholder="Nhập tiêu đề bài viết"
                required
              />
            </div>
            <div class="col-12" prop="content">
              <label>Nội dung </label>
              <textarea
                v-model="dataCreate.content"
                class="form-control rounded-0"
                rows="10"
              ></textarea>
            </div>
          </div>
          <div class="input-group-prepend">
            <p>Ảnh đính kèm</p>
          </div>
          <!-- <img src="url('storage/images/123.png')" alt="123" title="12" /> -->
          <div class="row">
            <div class="col-md-3" v-for="(item, key) in images" :key="key">
              <img
                v-if="item != ''"
                :src="item"
                class="img-responsive"
                height="60%"
                width="60%"
              />
              <button
                type="button"
                class="btn btn-danger remove-button"
                @click="removeImage(key)"
                v-if="item != ''"
              >
                Remove
              </button>
            </div>
            <div class="col-md-6">
              <input
                type="file"
                id="files"
                v-on:change="onImageChange"
                class="form-control custom-file"
                :limit="5"
                multiple
                ref="attachments"
              />
            </div>
          </div>
          <div class="col-12 button-submit">
            <button class="btn btn-primary" type="submit" v-if="!update">
              Save
            </button>
          </div>
        </form>
        <button
          class="btn btn-primary"
          v-if="update"
          @click="updatePost(dataCreate)"
        >
          Update
        </button>
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
      dataCreate: {
        title: "",
        content: "",
      },
      idPost: "",
      update: false,
      loadingButton: false,
      images: [],
      photos: [],
    };
  },
  methods: {
    updatePost(data) {
      axios
        .put(`/api/post/update/${this.idPost}`, data)
        .then((resp) => {
          this.handleBackdropClick();
          Swal.fire({
            icon: "success",
            title: "Update thành công",
            showConfirmButton: false,
            timer: 1500,
          });
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Lưu thất bại",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
    submitForm() {
      let formDatas = new FormData();
      for (var i = 0; i < this.photos.length; i++) {
        let file = this.photos[i];
        formDatas.append("photos[" + i + "]", file);
      }
      // this.photos.forEach((k,v) => {
      //   formDatas.append("photos['+ k + ']", value);
      // });
      for (var key in this.dataCreate) {
        formDatas.append(key, this.dataCreate[key]);
      }
      axios
        .post("/api/post/add", formDatas, config)
        .then((resp) => {
          this.handleBackdropClick();
          Swal.fire({
            icon: "success",
            title: "Lưu thành công",
            showConfirmButton: false,
            timer: 1500,
          });
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Lưu thất bại",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
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
      this.$parent.searchPropertis();
    },
    onImageChange() {
      let files = this.$refs.attachments.files;
      if (!files.length) return;

      for (let i = 0; i < files.length; i++) {
        this.photos.push(files[i]);
        this.createImage(files[i]);
      }
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.images.push(e.target.result);
      };
      reader.readAsDataURL(file);
    },
    removeImage: function (key) {
      this.images.splice(key, 1);
      if (this.images.length == 0) return;
    },
    getData(data) {
      this.update = true;
      this.idPost = data.postData.id;
      this.dataCreate.title = data.postData.title;
      this.dataCreate.content = data.postData.content;
      //   data.imageList.forEach((element) => {
      //     this.images.push(element.filename);
      //   });
    },
    // uploadImage() {
    //   axios.post("/image/store", { image: this.image }).then((response) => {
    //     if (response.data.success) {
    //       alert(response.data.success);
    //     }
    //   });
    // },
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
#submit {
  display: block;
  margin: auto;
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