<template>
  <section class="index">
    <div class="index__wrapper">
      <div class="index__left">
        <h2 class="index__title">今日やったことを投稿しよう！</h2>
        <p
          class="index__description"
        >Qiitaは、エンジニアリングに関する知識を記録・共有するためのサービスです。コードを書いていて気づいたことや、自分がハマったあの仕様について、他のエンジニアと知見を共有しましょう ;)</p>
      </div>
      <div class="index__right">
        <!-- Login components -->
        <h2>is logged in {{this.$auth.loggedIn}}</h2>
        <h2>username {{this.$auth.user.id}}</h2>
        <h2>username {{this.$auth.user.name}}</h2>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  components: {},
  data() {
    return {};
  },
  methods: {},

  created() {
    if (!this.$auth.loggedIn) {
      redirect("/login");
    } else {
      console.log("you are logged in");
    }
  }
};
</script>

<style lang='scss' scoped>
.index {
  &__wrapper {
    padding-top: 20px + 57px;
    display: flex;
    max-width: 1040px;
    margin: 0 auto;
  }

  &__left {
    width: 60%;
  }

  &__right {
    width: 40%;
  }

  &__description {
    line-height: 1.5;
  }
}
</style>
