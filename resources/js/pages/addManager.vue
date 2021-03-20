<template>
  <div class="app-content">
    <div class="search-group">
      <select class="custom-select col-sm-3 col-md-2 col-12">
        <option selected value="active">Đang hoạt động</option>
        <option selected value="noActive">Ngừng hoạt động</option>
        <option value="full">Full bạn bè</option>
        <option value="die">Die</option>
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
            <th scope="col">STT</th>
            <th scope="col">Tên nick fb</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Số lượng add</th>
            <th scope="col">Số lượng mời group</th>
            <th scope="col"><span>Tác vụ</span></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <th scope="row">{{ key + 1 }}</th>
            <td class="text-left">{{ item.nick_name }}</td>
            <td>{{ item.created_at }}</td>
            <td>{{ item.to_number }}</td>
            <td>{{ item.to_number_group }}</td>
            <td>
              <button type="button" class="btn btn-success">Disable</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>
<script>
import moment from "moment";

export default {
  components: {
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("Chi tiết add ngày") };
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
        .get(`/api/nick/detail-add-day?date=${this.dataSearch.date}`)
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