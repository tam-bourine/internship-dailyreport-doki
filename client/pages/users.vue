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
              <img class="users__img" src="../assets/img/koala.svg" alt />
              <div class="users__info">
                <nuxt-link
                  :to="{name: 'user-user', params: {user:user.id}}"
                  class="users__name"
                >{{user.name}}</nuxt-link>
                <p class="users__word">{{user.description}}</p>
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
      user: ""
    };
  },
  /*
  全ユーザーのデータを取得
   */
  created: async function() {
    let userData = await this.$axios.get("/users");
    this.userList = userData.data;
  }
};
</script>

<style lang="scss" scoped>
$tab: 1077px;
$sm: 524px;
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
  }

  &__right {
    width: 70%;
    margin: 0 auto;
    @include tab {
      margin-top: 16px;
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
</style>
