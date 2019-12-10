<template>
  <form action class="form">
    <div class="form__wrapper">
      <h2>Sign In</h2>
      <div class="form__title">
        <div class="form__inputs">
          <div class="form__input">
            <label for="email" class="form__label">Email Address</label>
            <input id="emial" type="email" />
          </div>

          <div class="form__input">
            <label for="password" class="form__label">Password</label>
            <input id="passowrd" type="password" />
          </div>
        </div>
      </div>
      <a class="form__btn">Submit</a>
      <p>
        Forgot
        <a class>password?</a>
      </p>
    </div>
  </form>
</template>

<script>
export default {
  methods: {
    /* Create User Account  */
    async createUser() {
      this.$axios.post("https://tango-dojo-api.herokuapp.com/createUser", {
        email: this.email,
        password: this.password
      });
    }
  }
};
</script>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap");

.form {
  font-family: "Noto Sans JP", sans-serif;
  &__wrapper {
    padding-top: 57+96px;
    max-width: 1100px;
    margin: 0 auto;
    text-align: center;
  }

  &__label {
    display: block;
  }

  &__btn {
    margin-top: 20px;
    display: inline-block;
    width: 20%;
    border-radius: 16px;
    background-color: #5679e8;
    color: #fff;
  }
}
</style>