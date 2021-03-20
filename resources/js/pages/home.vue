<template>
  <div class="app-content">
    <card :title="$t('home')">
      <!-- {{ $t('you_are_logged_in') }} -->
      <fetch-users />
    </card>
    <div class="daboard row text-center text-color">
      <div class="col-12 col-sm-5 col-md-3">
        <div class="item">
          <p>Số lượng nick của bạn</p>
          <p class="text-dark">{{ response.numerNick }}</p>
        </div>
      </div>
      <div class="col-12 col-sm-5 col-md-3">
        <div class="item">
          <p>HS add trong tháng</p>
          <p>{{ response.numberAdd }}</p>
        </div>
      </div>
      <div class="col-12 col-sm-5 col-md-3">
        <div class="item">
          <p>Số ngày đã add</p>
          <p class="text-warning">{{ response.numberDayAdd }}</p>
        </div>
      </div>
      <div class="col-12 col-sm-5 col-md-3">
        <div class="item">
          <p>Số ngày chưa add</p>
          <p class="text-danger">{{ response.numberdayNoAdd }}</p>
        </div>
      </div>
    </div>
    <!-- <div class="share-add d-flex col-12">
      <div v-for="(item, key) in responseList" class="col-sm-4">


        <div v-for="(image, key) in item.imageList" style="with:50px; height:50px">
          <img :src="image.filename" :alt="item.postData.title" style="with:100%; height:100%"/>
        </div>

        <div class="title-post">
          <h3 class=""></h3>
          <span>Ngày: {{ item.postData.created_at }}</span>
        </div>

        <div class="content">
          <p>{{ item.postData.content }}</p>
        </div>
      </div>
      
    </div> -->
    <div class="row">
      <div
        class="col-md-4 item-post"
        v-for="(item, key) in responseList"
        @click="viewDetailPost(item)"
      >
        <div class="author d-flex">
          <div class="author__avatar">
            <img
              :src="item.avatarAuthor"
              alt="Lights"
              class="rounded-circle profile-photo mr-1"
            />
          </div>
          <div class="author__detail">
            <p>{{ item.postData.create_by }}</p>
            <span>Ngày: {{ item.postData.created_at }}</span>
          </div>
        </div>
        <div class="thumbnail img-hover-zoom" v-if="item.imageList.length > 0">
          <div
            class="circular"
            v-bind:style="{
              backgroundImage: 'url(' + item.imageList[0].filename + ')',
            }"
          ></div>
          <!-- <img
            :src="item.imageList[0].filename"
            alt="Lights"
            style="width: 100%; height: 300px"
          /> -->
          <div class="caption">
            <h4>{{ item.postData.title }}</h4>
            <span>Detail</span>
          </div>
        </div>
        <div v-else style="margin: 20% 0% 0 0;">
          <h4>{{ item.postData.title }}</h4>
          <p>{{ item.postData.content.substring(0, 150) }}</p>
          <button>Detail</button>
        </div>
        
      </div>
    </div>
    <view-post
      :active.sync="showDetailPostDialog"
      @dialog-close="dialogCloseDetailPostMethod()"
      ref="viewPost"
    />
  </div>
</template>

<script>
import FetchUsers from "~/components/FetchUsers";
import Button from '../components/Button.vue';
import ViewPost from './post/viewPost.vue';
export default {
  components: {
    FetchUsers,
    ViewPost,
    Button,
  },
  middleware: "auth",

  metaInfo() {
    return { title: this.$t("home") };
  },
  data() {
    return {
      content: "",
      title: "",
      response: "",
      showDetailPostDialog:false,
      responseList: [],
    };
  },
  methods: {
    viewDetailPost(data) {
      this.showDetailPostDialog = true,
      this.$refs.viewPost.getData(data);
    },
    searchDataEmployee() {
      axios
        .get("/api/home/data")
        .then((resp) => {
          this.response = resp.data;
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
    searchDataPost() {
      axios
        .get("/api/home/post")
        .then((resp) => {
          this.responseList = resp.data;
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
    this.searchDataEmployee();
    this.searchDataPost();
  },
};
</script>

<style lang="scss" scoped>
.daboard {
  margin-bottom: 20px;
}
.item-post {
  cursor: pointer;
}
.share-add {
  padding: 0 10px;
  flex-flow: wrap;
}
.title-post {
  margin-bottom: 15px;
}
.thumbnail {
  display: block;
  position: relative;
  padding: 5px 5px 10px 5px;
  height: 300px;
  margin-bottom: 20px;
  line-height: 1.42857143;
  background-color: #fff;
  border: 1px solid #ddd;
  border-radius: 4px;
  transition: border 0.2s ease-in-out;
  .caption {
    position: absolute;
    left: 15px;
    bottom: 20px;
  }
  .circular {
    width: 100%;
    height: 100%;
    background-repeat: no-repeat;
    background-size: contain;
  }
}
.author {
  position: absolute;
  z-index: 1;
  left: 25px;
  top: 10px;
  &__avatar {
    margin-top: 10px;
  }
  &__detail {
    margin-left: 10px;
    p {
      font-weight: bold;
      margin: 0;
    }
  }
}
/* Colorize-zoom Container */
.thumbnail .circular {
  transition: transform 0.5s, filter 1.5s ease-in-out;
  // filter: grayscale(100%);
}

/* The Transformation */
.thumbnail:hover .circular {
  filter: grayscale(0);
  transform: scale(0.98);
}
</style>
