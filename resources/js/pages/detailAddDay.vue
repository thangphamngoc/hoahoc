<template>
  <div class="app-content">
    <div class="search-group">
      <select class="custom-select col-sm-3 col-md-2 col-12">
        <option selected value="1">Đang hoạt động</option>
        <option value="0">Full bạn bè</option>
        <option value="2">Ngừng hoạt động</option>
        <option value="4">Die</option>
      </select>
      <div class="input-group">
        <div class="col-sm-3 col-md-2 col-12 custom-date">
          <input
            class="form-control"
            type="date"
            v-model="dataSearch.date"
            id="example-date-input"
          />
        </div>
        <div class="form-outline">
          <input
            type="search"
            placeholder="Nhập sđt or name"
            lab
            class="form-control"
          />
        </div>
        <button type="button" class="btn btn-primary search-mb">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
    <div class="table-responsive-lg">
      <table class="table table-bordered table-hover">
        <thead>
          <tr class="table-nick text-center">
            <th scope="col" class="">STT</th>
            <th scope="col">Tên nick fb</th>
            <th scope="col">SDT/Email/Uid</th>
            <th scope="col">Password</th>
            <th scope="col">Url fb</th>
            <th scope="col">Tổng số bạn bè</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Trạng thái</th>
            <th scope="col"><span>Tác vụ</span></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <th scope="row">{{ key + 1 }}</th>
            <td scope="row" class="text-left">{{ item.nick_name }}</td>
            <td scope="row">{{ item.username_fb }}</td>
            <td scope="row">{{ item.password_fb }}</td>
            <td scope="row" class="text-left">{{ item.url_fb }}</td>
            <td scope="row">{{ item.number_friend }}</td>
            <td scope="row">{{ item.created_at }}</td>
            <td>
              <span v-if="item.status_nick == 1">Đang hoạt động</span>
              <span v-else-if="item.status_nick == 0">Full bạn bè</span>
              <span v-else-if="item.status_nick == 2">Không hoạt động</span>
              <span v-else>Die</span>
            </td>

            <td>
              <button
                type="button"
                class="btn btn-warning"
                @click="editDialogMethod(item)"
              >
                Sửa
              </button>
              <button type="button" class="btn btn-success">Disable</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-end">
      <button
        type="button"
        class="btn btn-success add-nick"
        @click="createDialogMethod()"
      >
        Thêm mới
      </button>
      <div class="btn-group">
        <button
          type="button"
          class="btn btn-success dropdown-toggle"
          data-toggle="dropdown"
          aria-haspopup="true"
          aria-expanded="false"
        >
          Tác vụ
        </button>
        <div class="dropdown-menu dropdown-menu-right">
          <a class="dropdown-item" href="#">Duyệt</a>
          <a class="dropdown-item" href="#">Hủy Duyệt</a>
          <a class="dropdown-item" href="#">Active</a>
          <!-- <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Separated link</a> -->
        </div>
      </div>
    </div>
    <addNick
      :active.sync="showCreateDialog"
      @dialog-close="dialogCloseCreateMethod()"
      ref="addNick"
    />
  </div>
</template>
<script>
import addNick from "./addNick.vue";
import moment from "moment";

export default {
  components: {
    addNick,
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("managerNick") };
  },
  data() {
    return {
      multipleSelection: [],
      responseList: [],
      loaddingButton: false,
      showCreateDialog: false,
      showUpdateDialog: false,
      dataSearch: {
        name: "",
        date: moment(new Date()).format("YYYY-MM-DD"),
      },
    };
  },
  methods: {
    createDialogMethod() {
      this.showCreateDialog = true;
    },
    editDialogMethod(data) {
      this.showCreateDialog = true;
      this.$refs.addNick.searchDetail(data);
    },

    searchPropertis() {
      axios
        .get("/api/nick/data")
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
  },
  beforeMount() {
    this.searchPropertis();
  },
};
</script>
<style lang="scss" scoped>
.add-nick {
  margin-right: 5px;
}
</style>