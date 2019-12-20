<template>
  <section class="setting">
    <div class="setting__wrapper">
      <h2 class="setting__title">{{this.$auth.user.name}}/ アカウント</h2>

      <div class="setting__box">
        <label class="setting__label" for="user-name">ユーザー名</label>
        <input class="setting__input" type="text" id="user-name" v-model="name" />
      </div>

      <div class="setting__box">
        <label class="setting__label" for="user-email">メールアドレス</label>
        <input class="setting__input" type="email" id="user-email" v-model="email" />
      </div>
      <div class="setting__box">
        <label class="setting__label" for="user-password">パスワードの変更</label>
        <input
          class="setting__input"
          type="password"
          id="user-password"
          :place-holder="password"
          v-model="password"
        />
        <a class="setting__btn" 　@click.prevent="updateUserInfo">更新する</a>
        <a class="setting__btn btn--warning" 　@click.prevent="deleteUser">アカウントを削除</a>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      email: this.$auth.user.email,
      name: this.$auth.user.name,
      password: this.$auth.user.password
    };
  },

  methods: {
    async updateUserInfo() {
      if (
        this.mailCheck(this.email) ||
        this.name == "" ||
        this.password.length < 8
      ) {
        alert(
          "メールアドレスを間違えているか、パスワードが8文字以下です(゜ロ゜)"
        );
        return;
      } else {
        try {
          const res = await this.$axios.put("/users/" + this.$auth.user.id, {
            name: this.name,
            email: this.email,
            password: this.password
          });
        } catch (error) {
          alert("エラーが起きました！入力内容を確認してください(｡・ε・｡)");
        }
      }
    },

    async deleteUser() {
      let res = await this.$axios.delete("/users/" + this.$auth.user.id);
      this.$auth.logout();
      console.log(res);
    },

    mailCheck(mail) {
      let mail_regex1 = new RegExp(
        "(?:[-!#-'*+/-9=?A-Z^-~]+.?(?:.[-!#-'*+/-9=?A-Z^-~]+)*|\"(?:[!#-[]-~]|\\\\[\x09 -~])*\")@[-!#-'*+/-9=?A-Z^-~]+(?:.[-!#-'*+/-9=?A-Z^-~]+)*"
      );
      let mail_regex2 = new RegExp("^[^@]+@[^@]+$");
      if (mail.match(mail_regex1) && mail.match(mail_regex2)) {
        if (
          mail.match(
            /[^a-zA-Z0-9\!\"\#\$\%\&\'\(\)\=\~\|\-\^\\\@\[\;\:\]\,\.\/\\\<\>\?\_\`\{\+\*\} ]/
          )
        ) {
          return false;
        }
        if (!mail.match(/\.[a-z]+$/)) {
          return false;
        }
        return true;
      } else {
        return false;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.setting {
  font-family: "Noto Sans JP", sans-serif;
  background-color: #eee;
  padding: 77px 0;
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  &__wrapper {
    margin-top: 30px;
    background-color: #fff;
    border: 1px solid #e5e5e5;
    padding: 64px 0;
    max-width: 720px;
    margin: 0 auto;
    text-align: center;
    border-radius: 8px;
  }

  &__title {
    font-size: 24px;
  }

  &__label {
    font-size: 14px;
    color: #555;
    font-weight: 700;
    text-align: left;
  }

  &__box {
    display: block;
    flex-direction: column;
    margin: 0 auto;
    margin-top: 32px;
    text-align: left;
    max-width: 500px;
  }
  &__input {
    display: block;
    font-size: 16px;
    width: 100%;
    padding: 8px 15px;
    border-radius: 8px;
    border: 0;
    background-color: #eee;
    border: 1px solid #ddd;
    margin-top: 16px;
  }

  &__btn {
    font-size: 16px;
    color: #fff;
    margin-top: 48px;
    display: inline-block;
    padding: 10px 20px;
    border-radius: 4px;
    cursor: pointer;
    background-color: #5679e8;
    &:hover {
      opacity: 0.7;
      transition: 0.3s;
    }
  }
}
input[type="text"],
input[type="password"],
textarea,
select {
  outline: 0;
}

.btn--warning {
  background-color: #e85679;
  margin-left: 24px;
}
</style>

