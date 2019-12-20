<template>
  <form action class="form">
    <div class="form__wrapper">
      <div class="form__card">
        <div class="toggle-switch">
          <input id="toggle" v-model="checked" class="toggle-input" type="checkbox" />
          <label for="toggle" class="toggle-label"></label>
        </div>
        <div class="form__info">
          <h2 class="form__title" v-if ='!checked'>ユーザー登録(oﾟ∀ﾟ)σ</h2>
          <h2　class='form__title' v-else>ログイン(｡･ω･)ﾉ</h2>
        </div>

        <div class="form__inputs">
          <div class="form__input-box">
            <transition name="fade">
              <div class="form__input-box">
                <input
                  v-if="!checked"
                  id="name"
                  class="form__input"
                  v-model="name"
                  placeholder="名前"
                  type="email"
                />
              </div>
            </transition>

            <input
              id="emial"
              class="form__input"
              v-model="email"
              placeholder="メールアドレス"
              type="email"
            />
          </div>

          <div class="form__input-box">
            <input
              id="passowrd"
              class="form__input"
              placeholder="パスワード"
              type="password"
              v-model="password"
            />
          </div>

          <a class="form__btn" @click.prevent="login()" v-if="checked">アカウントにログイン</a>
          <a class="form__btn" v-else @click.prevent="submitForm()">アカウントを作成する</a>
        </div>
                <a v-if='!checked' class="form__link" @click.prevent='checked=true'>既にアカウントを持っている場合はこちら</a>
      </div>
    </div>
  </form>
</template>

<script>
export default {
  components: {},

  data() {
    return {
      email: "",
      password: "",
      name: "",
      checked: false
    };
  },
  methods: {
    /* Create User Account  */
    async submitForm() {
      const token = await this.$axios.post("/users", {
        email: this.email,
        password: this.password,
        name: this.name
      });
      this.login();
    },

    async login() {
      try {
        await this.$auth.loginWith("local", {
          data: {
            email: this.email,
            password: this.password,
            name: this.name
          }
        });
      } catch (error) {
        console.log(error);
      }
    }
  }
};
</script>

<style lang="scss" scoped>
@import url("https://fonts.googleapis.com/css?family=Noto+Sans+JP&display=swap");

.form {
  font-family: "Noto Sans JP", sans-serif;
  padding-top: 57+96px;
  background-color: #eee;
  position: absolute;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;

  &__wrapper {
    max-width: 960px;
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
    font-weight: bold;
  }
  &__info {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  &__card {
    position: relative;
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

// input
.toggle-input {
  position: absolute;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  z-index: 5;
  opacity: 0;
  cursor: pointer;
}

// label
.toggle-label {
  width: 56px;
  height: 21px;
  background: #ccc;
  position: relative;
  display: inline-block;
  border-radius: 46px;
  transition: 0.4s;
  box-sizing: border-box;
  &:after {
    content: "";
    position: absolute;
    width: 20px;
    height: 20px;
    border-radius: 100%;
    left: 0;
    top: 0px;
    z-index: 2;
    background: #fff;
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
    transition: 0.4s;
  }
}

// input:ckeecked
.toggle-input:checked {
  + .toggle-label {
    background-color: #4bd865;
    &:after {
      left: 37px;
    }
  }
}

p {
  margin-top: 50px;
  text-align: center;
  font-weight: bold;
}

div {
  margin: auto;
}

.toggle-switch {
  position: absolute;
  margin: 0 0 0 30px;
  top: 40px;
  right: 32px;
}
</style>
