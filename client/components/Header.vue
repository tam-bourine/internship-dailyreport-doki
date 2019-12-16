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
        <a class="header__link">ストック一覧</a>
        <nuxt-link to="/editor" class="header__link">投稿する</nuxt-link>
      </div>
    </div>
  </header>
</template>

<script>
export default {};
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
  }
  &__box {
    display: flex;
    align-items: center;
  }
  &__title {
    max-width: 180px;
    vertical-align: sub;
  }

  &__btn {
    padding: 8px 4px;
    background-color: #2d4ba8;
    margin-left: 24px;
    cursor: pointer;
    font-size: 12px;
    color: #fff;
    border-radius: 5px;
  }

  &__logo-img {
    max-width: 30px;
    margin-right: -10px;
    transform: rotate(20deg);
  }
}

input[type="text"],
input[type="password"],
textarea,
select {
  outline: 0;
  color: orange;
}
</style>