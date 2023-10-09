<template>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
      <div class="container">
        <router-link to="/" class="navbar-brand">NetaShop</router-link>
        <button
          class="navbar-toggler"
          type="button"
          data-toggle="collapse"
          data-target="#navbarSupportedContent"
          aria-controls="navbarSupportedContent"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
            <li>
              <router-link to="/" class="nav-link" exact-active-class="text-success" active-class="active">
                <font-awesome-icon :icon="['fas', 'home']" />&nbsp;Trang chủ
              </router-link>
            </li>
            <li>
              <router-link to="/gioi-thieu" class="nav-link" exact-active-class="text-success" active-class="active">
                <font-awesome-icon :icon="['fab', 'twitter']" />&nbsp;Giới thiệu
              </router-link>
            </li>
            <li>
              <router-link to="/lien-he" class="nav-link" exact-active-class="text-success" active-class="active">
                <font-awesome-icon :icon="['fab', 'twitter']" />&nbsp;Liên hệ
              </router-link>
            </li>
          </ul>
        </div>
      </div>
    </nav>
  </template>

  <script>
  export default {
  }
  </script>

  <style></style>
