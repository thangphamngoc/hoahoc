function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },
  { path: '/about', name: 'about', component: page('about.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/registered', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  { path: '/manager-nick', name: 'nickManager', component: page('nickManager.vue') },
  { path: '/total-day-nick', name: 'totalDayNick', component: page('totalDayNick.vue') },
  { path: '/detail-add-day', name: 'detailAddDay', component: page('detailAddDay.vue') },


  { path: '/manager-add', name: 'addManager', component: page('addManager.vue') },
  { path: '/ctv/manager', name: 'ctvManager', component: page('ctv/ctvManager.vue') },
  { path: '/active/activeDay', name: 'activeDay', component: page('active/activeDay.vue') },

  { path: '/manager-post', name: 'postHome', component: page('post/postHome.vue') },
  { path: '/statistic/month', name: 'statisticMonth', component: page('statisc/month.vue') },
  // { path: '/statistic/year', name: 'statisticYear', component: page('statisc/year.vue') },





  { path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ] },

  { path: '*', component: page('errors/404.vue') }
]
