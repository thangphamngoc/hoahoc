import Vue from 'vue'
import store from '~/store'
import router from '~/router'
import i18n from '~/plugins/i18n'
import App from '~/components/App'
import FlashMessage from '@smartweb/vue-flash-message'
import swal from 'sweetalert2'
import moment from 'moment'

Vue.prototype.moment = moment



import '~/plugins'
import '~/components'

window.Swal = swal;
Vue.config.productionTip = false
window.axios = require('axios');
Vue.use(FlashMessage);
/* eslint-disable no-new */
new Vue({
  i18n,
  store,
  router,
  ...App
})
