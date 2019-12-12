<template>
  <section style="padding-top:200px;" class="userPage">
    <h2>You have succesfully logged in</h2>
    <p>{{user.name}}</p>
    <p>{{user.age}}</p>
    <button>ログアウトボタン</button>
  </section>
</template>

<script>
export default {
  middleware({ store, redirect }) {
    if (!store.$auth.loggedIn) {
      redirect("/signup");
    }
  },

  computed: {
    user() {
      return this.$auth.user;
    }
  },

  methods: {
    logout() {
      this.$auth.logout();
    }
  }
};
</script>

<style lang="scss" scoped>
</style>