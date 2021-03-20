<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
      <a @click="menuToggle()" class="menuToggle" v-if="user">
        <i class="fas fa-align-left"></i> Menu</a
      >
      <div class="container">
        <router-link
          :to="{ name: user ? 'home' : 'welcome' }"
          class="navbar-brand"
        >
          {{ appName }}
        </router-link>

        <!-- <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false">
        <span class="navbar-toggler-icon" />
      </button> -->

        <div id="navbarToggler" class="collapse navbar-collapse">
          <ul class="navbar-nav change-vi">
            <locale-dropdown />
            <!-- <li class="nav-item">
            <a class="nav-link" href="#">Link</a>
          </li> -->
          </ul>

          <ul class="navbar-nav ml-auto">
            <!-- Authenticated -->
            <li v-if="user" class="nav-item dropdown change-vi">
              <a
                class="nav-link dropdown-toggle text-dark"
                href="#"
                role="button"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
              >
                <img
                  :src="user.photo_url"
                  class="rounded-circle profile-photo mr-1"
                />
                {{ user.name }}
              </a>
              <div class="dropdown-menu">
                <router-link
                  :to="{ name: 'settings.profile' }"
                  class="dropdown-item pl-3"
                >
                  <fa icon="cog" fixed-width />
                  {{ $t("settings") }}
                </router-link>

                <div class="dropdown-divider" />
                <a href="#" class="dropdown-item pl-3" @click.prevent="logout">
                  <fa icon="sign-out-alt" fixed-width />
                  {{ $t("logout") }}
                </a>
              </div>
            </li>
            <!-- Guest -->
            <template v-else>
              <li class="nav-item">
                <router-link
                  :to="{ name: 'about' }"
                  class="nav-link"
                  active-class="active"
                >
                  {{ $t("about") }}
                </router-link>
              </li>
              <li class="nav-item">
                <router-link
                  :to="{ name: 'login' }"
                  class="nav-link"
                  active-class="active"
                >
                  {{ $t("login") }}
                </router-link>
              </li>
              <!-- <li class="nav-item">
                <router-link
                  :to="{ name: 'register' }"
                  class="nav-link"
                  active-class="active"
                >
                  {{ $t("register") }}
                </router-link>
              </li> -->
            </template>
          </ul>
        </div>
      </div>
    </nav>

    <!--menu left -->
    <nav
      class="wrapperMobile"
      v-if="user"
      id="sidebar"
      :class="{ active: selected == 0 }"
    >
      <!-- Sidebar -->
      <div style="width: 100%">
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
          <li class="active">
            <router-link :to="{ name: 'home' }"> Home </router-link>
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
              <li @click="menuToggle()">
                <router-link :to="{ name: 'nickManager' }">
                  Danh sách nick
                </router-link>
              </li>
              <li @click="menuToggle()">
                <router-link :to="{ name: 'totalDayNick' }">
                  Tổng add ngày
                </router-link>
              </li>
              <li @click="menuToggle()">
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
              <li @click="menuToggle()">
                <router-link :to="{ name: 'ctvManager' }">
                  CTV add hs
                </router-link>
              </li>
              <li @click="menuToggle()">
                <a href="#">CTV up page</a>
              </li>
              <li @click="menuToggle()">
                <a href="#">CTV nhóm</a>
              </li>
              <li @click="menuToggle()">
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
              <li @click="menuToggle()">
                <router-link :to="{ name: 'activeDay' }"> Ngày </router-link>
              </li>
              <li @click="menuToggle()">
                <a href="#">Tháng</a>
              </li>
              <li @click="menuToggle()">
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
              <li @click="menuToggle()">
                <a href="#">Nhóm 2003</a>
              </li>
              <li @click="menuToggle()">
                <a href="#">Nhóm 2004</a>
              </li>
              <li @click="menuToggle()">
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
              <li @click="menuToggle()">
                <router-link :to="{ name: 'statisticMonth' }">
                  Tổng hợp tháng
                </router-link>
              </li>
              <li @click="menuToggle()">
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
              <li @click="menuToggle()">
                <router-link :to="{ name: 'postHome' }">
                  Bài viết trang home
                </router-link>
              </li>
              <li @click="menuToggle()">
                <a href="#">Bài viết trang about</a>
              </li>
            </ul>
          </li>
          <li @click="menuToggle()">
            <a href="#">Khóa học</a>
          </li>
          <li @click="menuToggle()"> 
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
.wrapperMobile{
  z-index: 2;
}
</style>
