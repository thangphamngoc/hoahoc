<template>
  <div class="app-content">
    <div class="search-group">
      <select
        class="custom-select col-sm-3 col-md-2 col-12"
        v-model="dataSearch.status"
      >
        <option selected value="1">Đang làm</option>
        <option value="0">Nghỉ làm</option>
        <option value="2">Tạm nghỉ</option>
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
            @change="searchPropertis()"
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
            v-model="dataSearch.name"
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
            <th scope="col">Facebook</th>
            <th scope="col">Số nick add</th>
            <th scope="col">Ngày add</th>
            <th scope="col">Tổng add/day</th>
            <th scope="col">Tổng mời group/day</th>
            <th scope="col">Số ngày add</th>
            <th scope="col">Số ngày chưa add</th>
            <th scope="col">Tổng tháng</th>
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
            <td class="text-left">{{ item.infoEmployee.full_name }}</td>
            <td>0{{ item.infoEmployee.phone }}</td>
            <td>
              <a
                :href="item.infoEmployee.facebook"
                target="_blank"
                style="text-decoration: underline"
                >{{ item.infoEmployee.facebook }}</a
              >
            </td>
            <td class="text-center">
              {{ item.nickList.length }}
              <span @click="viewNick(item.nickList)" style="text-decoration: underline;cursor: pointer;">(xem) </span>
            </td>
            <td class="text-center">{{ dataSearch.date }}</td>
            <td class="text-center">
              <span v-if="item.dayTotal.length == 1">{{
                item.dayTotal[0].total_day
              }}</span>
              <span v-else>Ctv chưa add</span>
            </td>
            <td class="text-center">
              <span v-if="item.dayTotal.length == 1">{{
                item.dayTotal[0].total_add_group
              }}</span>
              <span v-else>Ctv chưa add</span>
            </td>
            <td class="text-center">{{ item.numberDay }}</td>
            <td class="text-center">{{ item.numberDayNo }}</td>
            <td class="text-center">{{ item.numberAdd }}</td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="d-flex justify-content-end">
      <!-- <button
        type="button"
        class="btn btn-success add-nick"
        @click="createDialogMethod()"
      >
        Thêm mới
      </button> -->
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
    <view-nick
      :active.sync="showViewNickDialog"
      @dialog-close="dialogCloseCreateMethod()"
      ref="viewNick"
    />
  </div>
</template>
<script>
// import ctvAdd from "./ctvAdd.vue";
import moment from "moment";
import ViewNick from "./viewNick.vue";

export default {
  components: {
    ViewNick,
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("Thống kê") };
  },
  data() {
    return {
      multipleSelection: [],
      responseList: [],
      loaddingButton: false,
      showCreateDialog: false,
      showViewNickDialog: false,
      showUpdateDialog: false,
      showImageDialog: false,
      dataSearch: {
        name: "",
        status: 1,
        date: moment(new Date()).format("YYYY-MM-DD"),
      },
      selected: [],
      selectAll: false,
    };
  },
  methods: {
    viewNick(data) {
      this.showViewNickDialog = true;
      this.$refs.viewNick.getData(data);
    },
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
    searchPropertis() {
      axios
        .get(`/api/statistic/month?date=${this.dataSearch.date}`)
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