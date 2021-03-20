<template>
  <div id="sidebar" :class="{ show: selected == 1, hide: selected == 0 }">
    <!--menu left -->
    <nav class="wrapper" v-if="user" ref="navbarLeft">
      <!-- Sidebar -->
      <div id="sidebar">
        <div class="sidebar-header">
          <router-link :to="{ name: 'home' }">
            <h3 align="center">
              <i
                class="fa fa-flask"
                aria-hidden="true"
                style="margin-right: 5px"
              ></i
              >Chemistry
            </h3>
          </router-link>
        </div>

        <ul class="list-unstyled components">
          <!-- <p>Dummy Heading</p> -->
          <li class="active d-flex" style="background: #6d7fcc">
            <router-link :to="{ name: 'home' }"> Home </router-link>
            <!-- <p
              style="
                width: 100%;
                display: flex;
                justify-content: flex-end;
                margin: 0 auto;
                cursor: pointer;
              "
              @click="menuToggle()"
            > -->
            <i
              @click="menuToggle()"
              class="fas fa-align-left"
              style="
                font-size: 25px;
                width: 50px;
                position: absolute;
                left: 10px;
                top: 10px;
                color: rgba(102, 51, 153, 0);
                cursor: pointer;
              "
            ></i>
            <!-- </p> -->
          </li>
          <li>
            <a
              href="#homeSubmenu1"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
              >Quản lý Nick</a
            >
            <ul class="collapse list-unstyled" id="homeSubmenu1">
              <li>
                <router-link :to="{ name: 'nickManager' }">
                  Danh sách nick
                </router-link>
              </li>
              <li>
                <router-link :to="{ name: 'totalDayNick' }">
                  Tổng add ngày
                </router-link>
              </li>
              <li>
                <router-link :to="{ name: 'addManager' }">
                  ADD hàng ngày
                </router-link>
              </li>
            </ul>
          </li>
          <li v-if="user.app_type == 'PLUS' || user.app_type == 'SYS'">
            <a
              href="#pageSubmenu2"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
              >Quản lý CTV</a
            >
            <ul class="collapse list-unstyled" id="pageSubmenu2">
              <li>
                <router-link :to="{ name: 'ctvManager' }">
                  CTV add hs
                </router-link>
              </li>
              <li>
                <a href="#">CTV up page</a>
              </li>
              <li>
                <a href="#">CTV nhóm</a>
              </li>
              <li>
                <a href="#">CTV giải bài tập</a>
              </li>
            </ul>
          </li>
          <li v-if="user.app_type == 'PLUS' || user.app_type == 'SYS'">
            <a
              href="#pageSubmenu5"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
              >Kích hoạt</a
            >
            <ul class="collapse list-unstyled" id="pageSubmenu5">
              <li>
                <router-link :to="{ name: 'activeDay' }"> Ngày </router-link>
              </li>
              <li>
                <a href="#">Tháng</a>
              </li>
              <li>
                <a href="#">Năm</a>
              </li>
            </ul>
          </li>
          <li>
            <a
              href="#pageSubmenu3"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
              >Quản lý nhóm</a
            >
            <ul class="collapse list-unstyled" id="pageSubmenu3">
              <li>
                <a href="#">Nhóm 2003</a>
              </li>
              <li>
                <a href="#">Nhóm 2004</a>
              </li>
              <li>
                <a href="#">Nhóm hóa học</a>
              </li>
            </ul>
          </li>
          <li>
            <a
              href="#pageSubmenu4"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
              >Tổng hợp</a
            >
            <ul class="collapse list-unstyled" id="pageSubmenu4">
              <li>
                <router-link :to="{ name: 'statisticMonth' }">
                  Tổng hợp tháng
                </router-link>
              </li>
              <li>
                <a href="#">Tổng hợp năm</a>
              </li>
            </ul>
          </li>
          <li>
            <a
              href="#pageSubmenu6"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
              >Quản lý bài viết</a
            >
            <ul class="collapse list-unstyled" id="pageSubmenu6">
              <li>
                <router-link :to="{ name: 'postHome' }">
                  Bài viết trang home
                </router-link>
              </li>
              <li>
                <a href="#">Bài viết trang about</a>
              </li>
            </ul>
          </li>
          <li>
            <a href="#">Khóa học</a>
          </li>
          <li>
            <a href="#">Contact</a>
          </li>
          <li class="nav-item dropdown user-left">
            <a
              href="#pageSubmenu"
              data-toggle="collapse"
              aria-expanded="false"
              class="dropdown-toggle"
            >
              <img
                :src="user.photo_url"
                class="rounded-circle profile-photo mr-1"
              />
              {{ user.name }}
            </a>
            <ul class="collapse list-unstyled" id="pageSubmenu">
              <li>
                <router-link
                  :to="{ name: 'settings.profile' }"
                  class="dropdown-item pl-3"
                >
                  <fa icon="cog" fixed-width />
                  {{ $t("settings") }}
                </router-link>
              </li>
              <li>
                <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                  <fa icon="sign-out-alt" fixed-width />
                  {{ $t("logout") }}
                </a>
              </li>
            </ul>

            <!-- <div class="dropdown-menu">
              <router-link :to="{ name: 'settings.profile' }" class="dropdown-item pl-3">
                <fa icon="cog" fixed-width />
                {{ $t('settings') }}
              </router-link>

              <div class="dropdown-divider" />
              <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                <fa icon="sign-out-alt" fixed-width />
                {{ $t('logout') }}
              </a>
            </div> -->
          </li>
        </ul>
      </div>
    </nav>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import LocaleDropdown from "./LocaleDropdown";

export default {
  components: {
    LocaleDropdown,
  },
  data() {
    return {
      appName: window.config.appName,
      selected: 0,
    };
  },

  computed: mapGetters({
    user: "auth/user",
  }),

  methods: {
    async logout() {
      // Log out the user.
      await this.$store.dispatch("auth/logout");

      // Redirect to login.
      this.$router.push({ name: "login" });
    },
    menuToggle() {
      this.selected = this.selected == 1 ? 0 : 1;
      this.checkToggle(this.selected);
    },
    checkToggle(data) {
      return;
    },
  },
};
</script>

<style scoped>
</style>
