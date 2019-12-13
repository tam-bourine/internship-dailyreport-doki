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
              <img class="users__img" :src="user.img" alt />
              <div class="users__info">
                <a href class="users__name">{{user.name}}</a>
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
      userList: []
    };
  },

  created: async function() {
    let userData = await this.$axios.get("http://localhost:5000/api/users");
    this.userList = userData.data;
  }
};
</script>

<style lang="scss" scoped>
.users {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;

  &__wrapper {
    padding-top: 77px;
    max-width: 1040px;
    display: flex;
    margin: 0 auto;
  }
  &__word {
    margin-top: 8px;
    font-size: 14px;
  }
  &__left {
    width: 30%;
    padding: 0 16px 16px 16px;
  }

  &__right {
    width: 70%;
  }
  &__title {
    font-size: 24px;
  }
  &__description {
    margin-top: 16px;
    line-height: 1.5;
    color: #aeaeae;
    font-size: 14px;
  }

  &__user {
    display: flex;
    align-items: center;
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