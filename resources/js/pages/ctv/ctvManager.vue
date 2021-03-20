<template>
  <div class="app-content">
    <div class="search-group">
      <select class="custom-select col-sm-3 col-md-2 col-12">
        <option selected value="active">Đang làm</option>
        <option selected value="noActive">Nghỉ làm</option>
        <option value="full">Tạm nghỉ</option>
      </select>
      <div class="input-group">
        <!-- <div class="form-group row"> -->
        <!-- <label for="example-date-input" class="col-2 col-form-label"
            >Date</label
          > -->
        <div class="col-sm-3 col-md-2 col-12 custom-date">
          <input
            class="form-control"
            type="date"
            v-model="dataSearch.date"
            id="example-date-input"
          />
        </div>
        <!-- </div> -->
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
            <th>
              <label class="form-checkbox">
                <input type="checkbox" v-model="selectAll" @click="select" />
                <i class="form-icon"></i>
              </label>
            </th>
            <th scope="col">STT</th>
            <th scope="col">Họ và tên</th>
            <th scope="col">SĐT</th>
            <th scope="col">Email</th>
            <th scope="col">Facebook</th>
            <th scope="col">STK</th>
            <th scope="col">Địa chỉ</th>
            <th scope="col">Học vấn</th>
            <th scope="col">Ảnh</th>
            <th scope="col">Ngày bắt đầu</th>
            <th scope="col">Trạng thái</th>
            <th scope="col"><span>Tác vụ</span></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <td>
              <label class="form-checkbox">
                <input type="checkbox" :value="item.id" v-model="selected" />
                <i class="form-icon"></i>
              </label>
            </td>
            <th scope="row" type="index">{{ key + 1 }}</th>
            <td class="text-left">{{ item.full_name }}</td>
            <td>{{ item.phone }}</td>
            <td>{{ item.email }}</td>
            <td>
              <a
                :href="item.facebook"
                target="_blank"
                style="text-decoration: underline"
                >{{ item.facebook }}</a
              >
            </td>
            <td>{{ item.bank }}</td>
            <td class="text-left">{{ item.address }}</td>
            <td>{{ item.education_level }}</td>
            <!-- <td> <img v-bind:src="item.avatar " /></td> -->
            <td>
              <p
                @click="viewImageDialogMethod(item.avatar)"
                style="text-decoration: underline; cursor: pointer"
              >
                Xem ảnh
              </p>
            </td>
            <td>{{ item.created_at }}</td>
            <td>
              <span v-if="item.employee_status == 1">Đang làm</span>
              <span v-else-if="item.employee_status == 0">Nghỉ làm</span>
              <span v-else-if="item.employee_status == 2">Tạm nghỉ</span>
            </td>

            <td>
              <button
                type="button"
                class="btn btn-warning"
                @click="editDialogMethod(item)"
              >
                Sửa
              </button>
              <button type="button" class="btn btn-success">Nghỉ làm</button>
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
          <a class="dropdown-item" href="#">Tạm nghỉ</a>
          <a class="dropdown-item" href="#">Đi làm</a>
          <a class="dropdown-item" href="#">Nghỉ làm</a>
          <!-- <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Separated link</a> -->
        </div>
      </div>
    </div>
    <ctvAdd
      :active.sync="showCreateDialog"
      @dialog-close="dialogCloseCreateMethod()"
      ref="ctvAdd"
    />
    <view-image
      :active.sync="showImageDialog"
      @dialog-close="dialogCloseViewMethod()"
      ref="viewImage"
    />
  </div>
</template>
<script>
import ctvAdd from "./ctvAdd.vue";
import moment from "moment";
import ViewImage from "../viewImage.vue";

export default {
  components: {
    ctvAdd,
    ViewImage,
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("managerCtv") };
  },
  data() {
    return {
      multipleSelection: [],
      responseList: [],
      loaddingButton: false,
      showCreateDialog: false,
      showUpdateDialog: false,
      showImageDialog: false,
      dataSearch: {
        name: "",
        date: moment(new Date()).format("YYYY-MM-DD"),
      },
      selected: [],
      selectAll: false,
    };
  },
  methods: {
    select() {
      this.selected = [];
      if (!this.selectAll) {
        for (let i in this.responseList) {
          this.selected.push(this.responseList[i].id);
        }
      }
      console.log(this.selected);
    },
    createDialogMethod() {
      this.showCreateDialog = true;
    },
    viewImageDialogMethod(data) {
      this.showImageDialog = true;
      this.$refs.viewImage.getData(data);
    },
    editDialogMethod(data) {
      this.showCreateDialog = true;
      this.$refs.ctvAdd.searchDetail(data);
    },

    searchPropertis() {
      axios
        .get("/api/ctv/data")
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