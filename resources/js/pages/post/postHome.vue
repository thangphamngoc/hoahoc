<template>
  <div class="app-content">
    <div class="search-group">
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
            placeholder="Nhập tiêu đề bài viết"
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
      <table class="table table-fixed table-bordered table-hover">
        <thead>
          <tr class="table-nick text-center">
            <th scope="col">STT</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col">Tiêu đề bài viết</th>
            <th scope="col">Nội dung bài viết</th>
            <th scope="col">Ảnh đính kèm</th>
            <th scope="col"><span>Tác vụ</span></th>
          </tr>
        </thead>
        <tbody>
          <tr class="text-center" v-for="(item, key) in responseList">
            <th scope="row">{{ key + 1 }}</th>
            <td>{{ item.postData.created_at }}</td>

            <td class="text-left">{{ item.postData.title.substring(0,50) }}...</td>
            <td>{{ item.postData.content.substring(0,50) }}...</td>
            <td @click="viewImageDialogMethod(item.imageList)">Xem ảnh</td>
            <td>
              <button
                type="button"
                class="btn btn-warning"
                @click="editDialogMethod(item)"
              >
                Sửa
              </button>
              <button type="button" class="btn btn-danger" @click="deleteDialogMethod(item.postData.id)">Delete</button>
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
        Tạo bài viết mới
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
    <add-post
      :active.sync="showCreateDialog"
      @dialog-close="dialogCloseCreateMethod()"
      ref="addPost"
    />

    <view-image
      :active.sync="showImageDialog"
      @dialog-close="dialogCloseViewMethod()"
      ref="viewImage"
    />
  </div>
</template>
<script>
import moment from "moment";
import AddPost from './addPost.vue';
import ViewImage from '../viewImage.vue';

export default {
  components: {
    AddPost,
    ViewImage,
  },
  middleware: "auth",
  metaInfo() {
    return { title: this.$t("managerPost") };
  },
  data() {
    return {
      multipleSelection: [],
      responseList: [],
      loaddingButton: false,
      showCreateDialog: false,
      showUpdateDialog: false,
      showImageDialog:false,
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
      this.$refs.addPost.getData(data);
    },
    viewImageDialogMethod(data) {
        let res = [];
        data.forEach(element => {
            res.push(element.filename);
        });
      this.showImageDialog = true;
      this.$refs.viewImage.getData(res);
    },
    searchPropertis() {
      axios
        .get("/api/home/post")
        .then((resp) => {
          this.responseList = resp.data;
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Lỗi dữ liệu",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    },
    deleteDialogMethod(id){
        axios
        .put(`/api/post/delete/${id}`)
        .then((resp) => {
          Swal.fire({
            icon: "success",
            title: "Xóa bài thành công",
            showConfirmButton: false,
            timer: 1500,
          });
          this.searchPropertis();
        })
        .catch((err) => {
          Swal.fire({
            icon: "error",
            title: "Xóa bài viết không thành công",
            showConfirmButton: false,
            timer: 1500,
          });
        });
    }
  },
  beforeMount() {
    this.searchPropertis();
  },
};
</script>
<style lang="scss" scoped>
// .table-fixed{
//   width: 100%;
//   tbody{
//     height:500px;
//     overflow-y:auto;
//     width: 100%;
//     }
//   thead,tbody{
//       display: block;
//     width: 100%;
//   }
//   tbody{
//     td{
//       float:left;
//     }
//   }
//   thead {
//     tr{
//     //   th{
//     //     float:left;
//     //    background-color: #f39c12;
//     //    border-color:#e67e22;
//     //   }
//     }
//   }
// }
.add-nick {
  margin-right: 5px;
}
</style>