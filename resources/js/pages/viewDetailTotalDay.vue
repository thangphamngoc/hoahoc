<template>
  <transition name="dialog">
    <div v-if="active" class="dialog-backdrop">
      <div class="dialog-container" @click.stop>
        <div class="d-flex justify-content-between">
          <h3>Chi tiết add hàng ngày</h3>
          <button
            type="button"
            class="btn btn-danger"
            @click="handleBackdropClick"
          >
            Close
          </button>
        </div>
        <hr />
        <div class="table-responsive-lg">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-nick text-center">
            <th scope="col" class="">STT</th>
            <th scope="col">Tên nick fb</th>
            <th scope="col">Ngày</th>
            <th scope="col">Số lượng add/ngày</th>
            <th scope="col">Số lượng mời vào group/ngày</th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <th scope="row">{{ key + 1 }}</th>
            <td scope="row">{{ item.nick_name }}</td>
            <td scope="row">{{ item.date_add }}</td>
            <td scope="row">{{ item.to_number }}</td>
            <td scope="row">{{ item.to_number_group }}</td>
            <!-- <td scope="row" class="text-left">{{ item.url_fb }}</td>
            <td scope="row">{{ item.number_friend }}</td>
            <td scope="row" class="moblie-display">{{ item.created_at }}</td>
            <td>
              <span v-if="item.status_nick == 1">Đang hoạt động</span>
              <span v-else-if="item.status_nick == 0">Full bạn bè</span>
              <span v-else-if="item.status_nick == 2">Không hoạt động</span>
              <span v-else>Die</span>
            </td> -->
          </tr>
        </tbody>
      </table>
    </div>
        <button
          class="btn btn-primary"
          v-if="update"
          @click="updateInfoNick(dataCreate)"
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
    totalDay: null,
  },
  data() {
    return {
      dataCreate: {
        nick_name: "",
        to_number: "",
        to_number: "",
        day_add_total_id: "",
        info_employee_id: "",
        date_add:"",
      },
      update: false,
      loadingButton: false,
      responseList: [],
    };
  },
  methods: {
    updateInfoNick(data) {
      axios
        .put("/api/nick/update", data)
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
      this.dataCreate.day_add_total_id = this.totalDay.id;
      this.dataCreate.info_employee_id = this.totalDay.info_employee_id;
      this.dataCreate.date_add = this.totalDay.date_add;
      axios
        .post("/api/nick/create-add-day", this.dataCreate)
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
      axios
        .get(`/api/nick/view-detail-day/${data.id}`)
        .then((resp) => {
          this.responseList = resp.data;
          console.log(this.responseList);
        })
        .catch((err) => {
          console.log(err);
          Swal.fire({
            icon: "error",
            title: "Lỗi dữ liệu",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
    closeDialog() {
      for (var key in this.dataCreate) {
        this.dataCreate[key] = "";
      }
      this.images = [];
      this.photos = [];
      this.$parent.searchPropertis();
    },
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