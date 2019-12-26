<template>
  <section class="users">
    <div class="users__wrapper">
      <div class="users__left">
        <h2 class="users__title">
          <font-awesome-icon icon="users" style="margin-right:16px;"></font-awesome-icon>ユーザー一覧
        </h2>
        <p
          class="users__description"
        >タンバリン日報システムに登録しているユーザーの一覧です。現在{{this.userList.length}}人のユーザーが登録しています。</p>
      </div>

      <div class="users__right">
        <ul>
          <li class="users__list" v-for="user in userList" :key="user.description">
            <div class="users__user">
              <img class="users__img" :src="getIcon(user.id)" alt="users-icon" />
              <div class="users__info">
                <nuxt-link
                  :to="{name: 'user-user', params: {user:user.id}}"
                  class="users__name"
                >{{user.name}}</nuxt-link>
                <p class="users__word" v-if="user.comment">{{user.comment}}</p>
                <p class="users__word" v-else>設定からひとことを追加しよう！</p>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      userList: [],
      user: "",
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
  /*
  全ユーザーのデータを取得
   */
  created: async function() {
    let userData = await this.$axios.get("/users");
    this.userList = userData.data;
  },

  methods: {
    getIcon(id) {
      if (id % 5 == 0) {
        return this.icons[0].image;
      } else if (id % 4 == 0) {
        return this.icons[1].image;
      } else if (id % 3 == 0) {
        return this.icons[2].image;
      } else if (id % 2 == 0) {
        return this.icons[3].image;
      } else {
        return this.icons[4].image;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
$tab: 1077px;
$sm: 524px;
$phone: 327px;
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

.users {
  background-color: #eee;
  padding-bottom: 20px;
  &__wrapper {
    padding-top: 77px;
    max-width: 1040px;
    display: flex;
    margin: 0 auto;
    @include tab {
      flex-direction: column;
      max-width: 900px;
    }
  }
  &__word {
    margin-top: 8px;
    font-size: 14px;
  }
  &__left {
    width: 30%;
    padding: 16px;
    background-color: #fff;
    margin-right: 16px;
    height: 100%;
    border-radius: 8px;

    @include tab {
      width: 70%;
      margin: 0 auto;
    }
    @include phone {
      width: 90%;
    }
  }

  &__right {
    width: 70%;
    margin: 0 auto;
    @include tab {
      margin-top: 16px;
    }
    @include phone {
      width: 90%;
    }
  }
  &__title {
    font-size: 24px;
    text-align: center;

    @include sm {
      font-size: 20px;
    }
  }
  &__description {
    margin-top: 16px;
    line-height: 1.5;
    font-size: 16px;
    @include sm {
      font-size: 14px;
    }
  }

  &__user {
    display: flex;
    align-items: center;
    background-color: #fff;
    padding: 8px;
    border-radius: 5px;
  }
  &__list {
    list-style: none;
    height: 56px;
    margin-top: 16px;
    border-bottom: 1px solid #ddd;
    &:nth-child(1) {
      margin-top: 0;
    }
  }

  &__img {
    max-width: 100%;
    width: 50px;
    margin-right: 8px;
    border-radius: 8px;
  }

  &__name {
    text-decoration: none;
    color: #67a3cd;
    font-size: 14px;
    &:hover {
      text-decoration: underline;
    }
  }
}
.active {
  background-color: #5679e8;
  color: #fff;
  pointer-events: none;
  &:hover {
    background-color: #33488b;
  }
}
</style>
