<template>
  <header class="header">
    <div class="header__wrapper">
      <div class="header__box">
        <h1 class="header__logo">
          <nuxt-link to="/" class="header__link">
            <img src="../assets/img/header__logo.png" alt class="header__logo-img" />
            <img src="../assets/img/header__title.png" alt class="header__title" />
          </nuxt-link>
        </h1>
        <nuxt-link to="/home" class="header__link">ホーム</nuxt-link>
        <nuxt-link to="/users" class="header__link">ユーザー一覧</nuxt-link>
      </div>
      <div class="header__box">
        <nuxt-link to="/editor" class="header__btn">
          <font-awesome-icon style="margin-right:8px" icon="edit" />投稿する
        </nuxt-link>
        <div class="header__user" v-if="this.$auth.loggedIn">
          <a class="header__toggleList" @click.prevent="clickedTest()">
            <img src="../assets/img/penguin.svg" alt="user-icon" class="header__icon" />
            <font-awesome-icon
              icon="caret-up"
              class="header__toggle-icon"
              :class="{active:clicked, notActive:!clicked}"
            ></font-awesome-icon>
          </a>
          <ul class="header__dropdown" v-if="clicked">
            <li class="header__dropdown-item">
              <h2 class="header__dropdown-name">Signed in as {{this.$auth.user.name}}</h2>
            </li>
            <li class="header__dropdown-item">
              <nuxt-link :to="{name: 'user-user', params: {user:this.$auth.user.id} }">
                <font-awesome-icon class="header__dropdown-icon" icon="address-card"></font-awesome-icon>マイページ
              </nuxt-link>
            </li>
            <li class="header__dropdown-item">
              <nuxt-link to="/account">
                <font-awesome-icon class="header__dropdown-icon" icon="cog"></font-awesome-icon>設定
              </nuxt-link>
            </li>
            <li class="header__dropdown-item">
              <a href　@click.prevent="logout()">
                <font-awesome-icon class="header__dropdown-icon" icon="lock" 　></font-awesome-icon>ログアウト
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </header>
</template>

<script>
export default {
  data() {
    return {
      clicked: false,
      nippoAmount: 0
    };
  },

  created: async function() {
    this.clicked = false;
  },

  methods: {
    clickedTest() {
      this.clicked = !this.clicked;
    },

    logout() {
      this.$auth.logout();
    }
  },
  beforeRouteLeave() {
    this.clicked = false;
  }
};
</script>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap");

.header {
  font-family: "Noto Sans JP", sans-serif;
  background-color: #5679e8;
  position: fixed;
  width: 100%;
  z-index: 1;
  &__wrapper {
    max-width: 1100px;
    padding: 5px 0;
    margin: 0 auto;
    display: flex;
    justify-content: space-between;
  }

  &__link {
    color: #fff;
    font-size: 14px;
    text-decoration: none;
    margin-left: 25px;
    cursor: pointer;
    &:hover {
      opacity: 0.8;
      transform: 0.3s;
    }
  }
  &__box {
    display: flex;
    align-items: center;
    &:nth-child(2) {
      margin-right: 20px;
    }
  }
  &__title {
    max-width: 180px;
    vertical-align: sub;
  }

  &__icon {
    max-width: 30px;
  }

  &__btn {
    padding: 10px 12px;
    background-color: #41579c;
    margin-left: 24px;
    cursor: pointer;
    font-size: 12px;
    color: #fff;
    border-radius: 5px;
    text-decoration: none;
    &:hover {
      transition: 0.4;
      background-color: #314275;
    }
  }

  &__logo-img {
    max-width: 30px;
    margin-right: -15px;
    transform: rotate(20deg);
  }

  &__user {
    display: flex;
    align-items: center;
    margin-left: 8px;
    position: relative;
  }

  &__toggle-icon {
    color: #ddd;
    position: relative;
    top: -10px;
    &:hover {
      color: #fff;
    }
  }

  &__toggleList {
    cursor: pointer;
    user-select: none;
  }
  &__icon {
    width: 100%;
    max-width: 40px;
  }
  &__dropdown {
    position: absolute;
    top: 54px;
    width: 180px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    left: -140px;
    padding: 5px 10px;
    border-radius: 8px;
  }
  &__dropdown-icon {
    margin-right: 8px;
    font-size: 13px;
  }
  &__dropdown-item {
    list-style: none;
    font-size: 12px;
    padding: 12px;
    text-align: left;
    padding-left: 40px;
    &:hover {
      background-color: #5679e8;
      color: #fff;
    }
    > a {
      text-decoration: none;
      color: inherit;
      user-select: none;
    }

    &:nth-child(1) {
      margin-top: 0;
      padding: 12px 0;
      border-bottom: 1px solid #e5e5e5;

      &:hover {
        background-color: #fff;
        color: black;
      }
    }
  }
  &__dropdown-name {
    font-size: 14px;
    font-weight: 400;
    text-align: center;
    &:hover {
      color: black;
    }
  }
}

.active {
  color: #fff;
  transition: 0.3s;
  transform: rotate(-180deg);
}

.notActive {
  transform: rotate(0deg);
  transition: 0.3s;
}

input[type="text"],
input[type="password"],
textarea,
select {
  outline: 0;
  color: orange;
}
</style>
