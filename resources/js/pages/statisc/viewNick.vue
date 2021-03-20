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
                <th scope="col">Url</th>
                <th scope="col">Số bạn bè thêm trong ngày</th>
                <th scope="col">Trạng thái</th>
              </tr>
            </thead>
            <tbody>
              <tr class="text-center" v-for="(item, key) in responseList">
                <th scope="row">{{ key + 1 }}</th>
                <td scope="row">{{ item.nick_name }}</td>
                <td scope="row">{{ item.url_fb }}</td>
                <td scope="row">{{ item.number_friend }}</td>
                <td scope="row">
                  <span v-if="item.status_nick == 1">Đang hoạt động</span>
                  <span v-else-if="item.status_nick == 0">Full bạn bè</span>
                  <span v-else-if="item.status_nick == 2">Không hoạt động</span>
                  <span v-else>Die</span>
                </td>
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
      update: false,
      loadingButton: false,
      responseList: [],
    };
  },
  methods: {
    handleBackdropClick() {
      this.$emit("update:active", false);
      this.closeDialog();
      this.update = false;
    },
    closeDialog() {
      for (var key in this.dataCreate) {
        this.dataCreate[key] = "";
      }
      this.images = [];
      this.photos = [];
      this.$parent.searchPropertis();
    },
    getData(data) {
      this.responseList = data;
      console.log(this.responseList);
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