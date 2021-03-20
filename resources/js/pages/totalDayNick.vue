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
            <th scope="col">Ngày add</th>
            <th scope="col">Số lượng add/ngày</th>
            <th scope="col">Số lượng mời vào group/ngày</th>
            <th scope="col"><span>Tác vụ</span></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <th scope="row">{{ key + 1 }}</th>
            <td scope="row">{{ item.date_add }}</td>
            <td scope="row">{{ item.total_day }}</td>
            <td scope="row">{{ item.total_add_group }}</td>
            <!-- <td scope="row" class="text-left">{{ item.url_fb }}</td>
            <td scope="row">{{ item.number_friend }}</td>
            <td scope="row" class="moblie-display">{{ item.created_at }}</td>
            <td>
              <span v-if="item.status_nick == 1">Đang hoạt động</span>
              <span v-else-if="item.status_nick == 0">Full bạn bè</span>
              <span v-else-if="item.status_nick == 2">Không hoạt động</span>
              <span v-else>Die</span>
            </td> -->

            <td>
              <button
                type="button"
                class="btn btn-warning"
                @click="editDialogMethod(item)"
              >
                Điền add
              </button>
              <button type="button" class="btn btn-success" @click="viewDetail(item)">Xem chi tiết</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-end">
      <button type="button" class="btn btn-success add-nick">Thêm mới</button>
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
    <detail-total-day
      v-bind:totalDay="totalDay"
      :active.sync="showCreateDialog"
      @dialog-close="dialogCloseCreateMethod()"
      ref="detailTotalDay"
    />
    <view-detail-total-day
      :active.sync="showViewDetailDialog"
      @dialog-close="dialogCloseViewDetailMethod()"
      ref="viewDetailTotalDay"
    />
  </div>
</template>
<script>
import moment from "moment";
import DetailTotalDay from "./detailTotalDay.vue";
import ViewDetailTotalDay from './viewDetailTotalDay.vue';

export default {
  components: {
    DetailTotalDay,
    ViewDetailTotalDay,
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("Quản lý Nick") };
  },
  data() {
    return {
      multipleSelection: [],
      responseList: [],
      loaddingButton: false,
      showCreateDialog: false,
      showViewDetailDialog: false,
      showUpdateDialog: false,
      totalDay: "",
      dataSearch: {
        name: "",
        date: moment(new Date()).format("YYYY-MM-DD"),
      },
    };
  },
  methods: {
    viewDetail(data){
      this.showViewDetailDialog = true;
      this.$refs.viewDetailTotalDay.searchDetail(data);
    },
    createDialogMethod() {
      this.showCreateDialog = true;
    },
    editDialogMethod(data) {
      this.totalDay = data;
      this.showCreateDialog = true;
      this.$refs.detailTotalDay.searchDetail(data);
    },

    searchPropertis() {
      axios
        .get("/api/total/data")
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