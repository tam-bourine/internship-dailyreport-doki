<template>
  <section class="index">
    <div class="index__wrapper">
      <h2>ログイン済み</h2>
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

  mounted() {
    if (!this.$auth.loggedIn) {
      this.$router.push("/login");
    } else {
      this.$router.push("/home");
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
