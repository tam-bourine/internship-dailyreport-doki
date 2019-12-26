<template>
  <section class="setting">
    <div class="setting__wrapper">
      <form action class="setting__form">
        <div class="setting__user-info">
          <img :src="getIcon()" class="setting__icon" alt="user-icon" />
          <h2 class="setting__title">{{this.$auth.user.name}} / アカウント</h2>
        </div>

        <div class="setting__box">
          <label class="setting__label" for="user-name">ユーザー名</label>
          <input class="setting__input" type="text" id="user-name" v-model="name" />
        </div>

        <div class="setting__box">
          <label class="setting__label" for="user-email">メールアドレス</label>
          <input class="setting__input" type="email" id="user-email" v-model="email" />
        </div>

        <div class="setting__box">
          <label class="setting__label" for="user-comment">ひとこと</label>
          <input class="setting__input" type="text" id="user-comment" v-model="comment" />
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
      </form>
    </div>
  </section>
</template>

<script>
export default {
  data() {
    return {
      email: this.$auth.user.email,
      name: this.$auth.user.name,
      password: this.$auth.user.password,
      comment: this.$auth.user.comment,
      icons: [
        {
          image: require("~/assets/img/giraffe.svg")
        },
        {
          image: require("~/assets/img/bird.svg")
        },
        {
          image: require("~/assets/img/hippo.svg")
        },
        {
          image: require("~/assets/img/whale.svg")
        },
        {
          image: require("~/assets/img/penguin.svg")
        }
      ],
      requesting: false
    };
  },

  methods: {
    /*
    バリデーションを通れば、ユーザーの情報を更新する。
     */
    async updateUserInfo() {
      if (
        !this.mailCheck(this.email) ||
        this.name == "" ||
        !this.passwordCheck(this.password)
      ) {
        alert(
          "入力内容に不備があります！(゜ロ゜)\n[確認]パスワード:８文字以上\n[確認]ひとこと20字以内\n[確認]正しいメールアドレス"
        );
        return;
      } else {
        this.requesting = true;
        try {
          const res = await this.$axios.put("/users/" + this.$auth.user.id, {
            name: this.name,
            email: this.email,
            password: this.password
          });
        } catch (error) {
          alert("エラーが起きました！入力内容を確認してください(｡・ε・｡)");
        }

        const res2 = await this.$axios.post(
          "/users/" + this.$auth.user.id + "/comment",
          {
            comment: this.comment
          }
        );

        alert("ユーザー情報が更新されました！");
        this.requesting = false;
      }
    },
    /*
    ユーザーをデータベースから完全に削除する。
    */
    async deleteUser() {
      if (this.isRequesting()) return;
      this.requesting = true;
      let res = await this.$axios.delete("/users/" + this.$auth.user.id);
      this.isRequesting = false;
      this.$auth.logout();
    },
    /*
    メールのバリデーション確認。
    */
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
        console.log("wrong mail address");
        return false;
      }
    },

    passwordCheck(password) {
      if (password != undefined) {
        if (this.password.length >= 8) {
          alert("return true");
          return true;
        } else {
          alert("return false");
          return false;
        }
      } else {
        return false;
      }
    },

    /*
    Apiリクエスト中であれば新しいリクエストを無視する
    連打防止用
     */
    isRequesting() {
      if (this.requesting) {
        alert("すでにリクエストを送っています！しばらくお待ちください(´·ω·`)");
        return true;
      } else {
        return false;
      }
    },

    getIcon() {
      console.log(this.$auth.user);
      if (this.$auth.user.id % 5 == 0) {
        return this.icons[0].image;
      } else if (this.$auth.user.id % 4 == 0) {
        return this.icons[1].image;
      } else if (this.$auth.user.id % 3 == 0) {
        return this.icons[2].image;
      } else if (this.$auth.user.id % 2 == 0) {
        return this.icons[3].image;
      } else {
        return this.icons[4].image;
      }
    }
  }
};
</script>

<style lang="scss" scoped>
$tab: 993px;
$sm: 740px;
$xsm: 614px;
$phone: 411px;

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

@mixin xsm {
  @media (max-width: ($xsm)) {
    @content;
  }
}

@mixin phone {
  @media (max-width: ($phone)) {
    @content;
  }
}

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
    max-width: 720px;
    margin: 0 auto;
    text-align: center;
    border-radius: 8px;

    @include sm {
      max-width: 500px;
      padding: 32px 0;
    }
  }
  &__form {
    background-color: #fff;
    border: 1px solid #e5e5e5;
    margin: 0 auto;
    padding: 64px;

    @include sm {
      width: 90%;

      padding: 32px;
    }
  }
  &__icon {
    max-width: 50px;
    margin-right: 8px;
  }
  &__title {
    font-size: 24px;

    @include phone {
      font-size: 16px;
    }
  }

  &__user-info {
    display: flex;
    justify-content: center;
    align-items: center;
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
    @include sm {
      font-size: 14px;
    }
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
  @include phone {
    margin-left: 14px;
  }
}
</style>

