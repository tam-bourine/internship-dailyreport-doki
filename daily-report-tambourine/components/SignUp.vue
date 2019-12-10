<template>
  <form action class="form">
    <div class="form__wrapper">
      <div class="form__card">
        <h2 class="form__title">Let's get started</h2>
        <div class="form__inputs">
          <div class="form__input-box">
            <input id="emial" class="form__input" placeholder="メールアドレス" type="email" />
          </div>

          <div class="form__input-box">
            <input id="passowrd" class="form__input" placeholder="パスワード" type="password" />
          </div>
          <a class="form__btn">アカウントを作成する</a>
          <a class="form__link">既にアカウントを持っている場合はこちら</a>
        </div>
      </div>
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
    },

    async submitForm() {
      const token = await this.$axios.post(
        "https://tango-dojo-api.herokuapp.com/submit",
        {
          email: this.email,
          password: this.password
        }
      );

      // this.$state.dispatch('')
    }
  }
};
</script>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap");

.form {
  font-family: "Noto Sans JP", sans-serif;
  padding-top: 57+96px;
  background-color: #e4e7fd;
  &__wrapper {
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
    width: 85%;
    border-radius: 10px;
    background-color: #5679e8;
    color: #fff;
    padding: 16px 50px;

    transition: 0.7s;

    &:hover {
      opacity: 0.8;
      cursor: pointer;
    }
  }

  &__title {
    font-size: 24px;
  }

  &__card {
    background-color: white;
    max-width: 467px;
    max-width: 50%;
    margin: 0 auto;
    padding: 44px 33px 30px 33px;
    border-radius: 10px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.12), 0 1px 2px rgba(0, 0, 0, 0.24);
    transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  }

  &__inputs {
    margin-top: 20px;
  }
  &__input {
    padding: 13px 10px;
    font-size: 14px;
    border-radius: 8px;
    outline: 0;
    width: 85%;
    border: 0;
    background-color: #edeef7;
    margin-top: 25px;
  }

  input[type="text"],
  input[type="password"],
  textarea,
  select {
    outline: 0;
  }

  &__link {
    display: block;
    margin-top: 40px;
    font-size: 14px;
    color: #337ab7;
    cursor: pointer;
    &:hover {
      opacity: 0.7;
      transition: 0.7s;
    }
  }
}
</style>