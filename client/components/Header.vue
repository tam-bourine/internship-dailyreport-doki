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
        <nuxt-link to="/home" class="header__link header__mobile-disable">ホーム</nuxt-link>
        <nuxt-link to="/users" class="header__link header__mobile-disable">ユーザー一覧</nuxt-link>
      </div>
      <div class="header__box">
        <nuxt-link to="/editor" class="header__btn">
          <font-awesome-icon style="margin-right:8px" icon="edit" />投稿する
        </nuxt-link>
        <div class="header__user" v-if="this.$auth.loggedIn">
          <a class="header__toggleList" @click.prevent="open()" v-click-outside="close">
            <img :src="getIcon()" alt="user-icon" class="header__icon" />
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
              <nuxt-link to="/home">
                <font-awesome-icon class="header__dropdown-icon" icon="home"></font-awesome-icon>ホーム
              </nuxt-link>
            </li>
            <li class="header__dropdown-item">
              <nuxt-link to="/users">
                <font-awesome-icon class="header__dropdown-icon" icon="users"></font-awesome-icon>ユーザー一覧
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
import ClickOutside from "vue-click-outside";
export default {
  data() {
    return {
      clicked: false,
      nippoAmount: 0,
      icons: [
        {
          image: require("~/assets/img/giraffe.svg")
        },
        {
          image: require("~/assets/img/bird.svg")
        },
        {
          image: require("~/assets/img/hippo.svg")
        },
        {
          image: require("~/assets/img/whale.svg")
        },
        {
          image: require("~/assets/img/penguin.svg")
        }
      ]
    };
  },
  directives: {
    ClickOutside
  },
  created: async function() {
    this.clicked = false;
  },

  methods: {
    /*
    トグルリストを表示。
    */
    open() {
      this.clicked = true;
    },

    /*
    保存しているトークン、ユーザーデータを破棄。
    */
    logout() {
      this.$auth.logout();
    },
    /*
    トグルリストを非表示
    */
    close() {
      this.clicked = false;
    },

    getIcon() {
      if (this.$auth.user.id % 5 == 0) {
        return this.icons[0].image;
      } else if (this.$auth.user.id % 4 == 0) {
        return this.icons[1].image;
      } else if (this.$auth.user.id % 3 == 0) {
        return this.icons[2].image;
      } else if (this.$auth.user.id % 2 == 0) {
        return this.icons[3].image;
      } else {
        return this.icons[4].image;
      }
    }
  },

  beforeRouteLeave() {
    this.clicked = false;
  }
};
</script>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap");

$tab: 614px;
$sm: 528px;
$phone: 411px;
@mixin tab {
  @media (max-width: ($tab)) {
    @content;
  }
}
@mixin sm {
  @media (max-width: ($sm)) {
    @content;
  }
}

@mixin phone {
  @media (max-width: ($phone)) {
    @content;
  }
}

.header {
  font-family: "Noto Sans JP", sans-serif;
  background-color: #5679e8;
  position: fixed;
  width: 100%;
  z-index: 999;
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

    @include tab {
      font-size: 14px;
      margin-left: 14px;
    }

    @include sm {
      font-size: 12px;
      margin-left: 10px;
    }
  }
  &__box {
    display: flex;
    align-items: center;
    &:nth-child(2) {
      margin-right: 20px;
      @include sm {
        margin-right: 8px;
      }
    }
  }
  &__title {
    max-width: 180px;
    vertical-align: sub;
    @include tab {
      max-width: 130px;
    }
  }

  &__icon {
    max-width: 30px;
    @include tab {
      max-width: 20px;
    }
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
    @include tab {
      max-width: 20px;
      margin-right: -8px;
    }
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

  &__mobile-disable {
    @include sm {
    }
    @include phone {
      display: none;
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
