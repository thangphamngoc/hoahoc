<template>
  <transition name="dialog">
    <div v-if="active" class="dialog-backdrop">
      <div class="dialog-container" @click.stop>
        <div class="d-flex justify-content-between">
          <h3>Thêm mới Ctv</h3>
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
          @submit.prevent="submitForm"
        >
          <div class="form-row">
            <div class="col-md-4 mb-3" prop="full_name">
              <label>Tên CTV </label>
              <input
                type="text"
                v-model="dataCreate.full_name"
                class="form-control"
                aria-describedby="emailHelp"
                placeholder="Nhập tên CTV"
                required
              />
              <!-- <small id="emailHelp" class="form-text text-muted"
                >We'll never share your email with anyone else.</small
              > -->
            </div>
            <div class="col-md-4 mb-3" prop="phone">
              <label>Số điện thoại </label>
              <input
                v-model="dataCreate.phone"
                type="number"
                class="form-control"
                placeholder="Nhập SĐT"
                required
              />
            </div>
            <div class="col-md-4 mb-3" prop="facebook">
              <label>Địa chỉ FB </label>
              <input
                v-model="dataCreate.facebook"
                type="text"
                class="form-control"
                placeholder="Nhập url facebook"
                required
              />
            </div>
            <div class="col-md-4 mb-3" prop="email">
              <label>Email </label>
              <input
                v-model="dataCreate.email"
                type="text"
                class="form-control"
                placeholder="Nhập email"
                required
              />
            </div>
            <div class="col-md-4 mb-3" prop="bank">
              <label>Tài khoản ngân hàng </label>
              <input
                v-model="dataCreate.bank"
                type="number"
                class="form-control"
                placeholder="Nhập số tài khoản"
                required
              />
            </div>
            <div class="col-md-4 mb-3" prop="address">
              <label>Địa chỉ nơi ở </label>
              <input
                v-model="dataCreate.address"
                type="text"
                class="form-control"
                placeholder="Nhập địa chỉ"
                required
              />
            </div>
            <div class="col-md-4 mb-3" v-if="update == true">
                <label>Trạng thái </label>
            <select
              
              class="form-select form-select-lg col-md-12" style="padding: 5px 0 6px 5px;"
              v-model="dataCreate.employee_status"
            >
              <option selected value="1">Đang làm</option>
              <option value="0">Nghỉ làm</option>
              <option value="2">Tạm nghỉ</option>
            </select>
            </div>
            <div class="col-md-4 mb-3" prop="education_level">
              <label>Trường đang theo học </label>
              <input
                v-model="dataCreate.education_level"
                type="text"
                class="form-control"
                placeholder="Nhập trường học"
                required
              />
            </div>
            <!-- <div class="form-check">
              <input
                type="checkbox"
                class="form-check-input"
                id="exampleCheck1"
              />
              <label class="form-check-label" for="exampleCheck1"
                >Check me out</label
              >
            </div> -->
          </div>
          <div class="input-group-prepend" v-if="update == true">
            <p>Upload Avatar</p>
          </div>
          <!-- <img src="url('storage/images/123.png')" alt="123" title="12" /> -->
          <div class="row" v-if="update == true">
            <div class="col-md-3" v-if="images != ''">
              <img
                :src="images"
                class="img-responsive"
                height="90%"
                width="90%"
              />
              <button
                type="button"
                class="btn btn-danger remove-button"
                @click="removeImage()"
                v-if="images != ''"
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
                ref="attachments"
              />
            </div>
            <!-- <div class="col-md-3">
                  <button
                    class="btn btn-success btn-block"
                    @click="uploadImage"
                  >
                    Upload Image
                  </button>
                </div> -->
          </div>
          <div class="col-12 button-submit">
            <button
              class="btn btn-primary"
              type="submit"
              v-if="update == false"
            >
              Save
            </button>
          </div>
        </form>
        <button
          class="btn btn-primary"
          v-if="update == true"
          value="0"
          @click="updateInfoEmployee(dataCreate)"
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
        edu: "",
        address: "",
        bank: "",
        facebookUrl: "",
        phone: "",
        fullName: "",
        email: "",
      },
      update: false,
      loadingButton: false,
      images: "",
      photos: [],
    };
  },
  methods: {
    updateInfoEmployee(data) {
      console.log(data);
      let form = new FormData();
      Object.entries(data).forEach(([k,v]) =>{
        form.append(k, v);
      })
      form.append('_method', 'PUT')
      axios
        .post("/api/ctv/update", form)
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
      if (this.images != "") {
        formDatas.append("avatar", this.images);
      }
      for (var key in this.dataCreate) {
        formDatas.append(key, this.dataCreate[key]);
      }
      axios
        .post("/api/ctv/add", formDatas, config)
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
    },
    closeDialog() {
      for (var key in this.dataCreate) {
        this.dataCreate[key] = "";
      }
      this.images = [];
      this.photos = [];
      this.$parent.searchPropertis();
    },
    onImageChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      if (!files.length) return;
      this.dataCreate.avatar = files[0];
      this.createImage(files[0]);
    },
    createImage(file) {
      let reader = new FileReader();
      let vm = this;
      reader.onload = (e) => {
        vm.images = e.target.result;
      };
      reader.readAsDataURL(file);
    },
    removeImage() {
      this.images = "";
      if (this.images == "") return;
    },
    // uploadImage() {
    //   axios.post("/image/store", { image: this.image }).then((response) => {
    //     if (response.data.success) {
    //       alert(response.data.success);
    //     }
    //   });
    // },
  },
  // beforeMount() {
  //   this.searchPropertis();
  // },
};
</script>

<style scoped>
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