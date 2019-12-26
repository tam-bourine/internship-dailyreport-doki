<template>
  <article class="nippo">
    <div class="nippo__wrapper">
      <div class="nippo__user">
        <img :src="getIcon()" alt="user-icon" class="nippo__user-icon" />
      </div>
      <div class="nippo__content">
        <div class="nippo__info">
          <div class="nippo__infos">
            <nuxt-link
              :to="{name: 'user-user', params: {user:this.id} }"
              class="nippo__user-link"
            >{{this.author}}</nuxt-link>
            <time style="color:#b8b8b8" class="nippo__time">{{this.time}}</time>
          </div>
          <div class="nippo__change" v-if="admin">
            <a href class="nippo__btn btn--edit" @click.prevent="editPost()">
              <font-awesome-icon icon="edit" class="nippo__btn-icon"></font-awesome-icon>
            </a>
            <a href class="nippo__btn btn--delete" @click.prevent="deletePost()">
              <font-awesome-icon icon="trash" class="nippo__btn-icon"></font-awesome-icon>
            </a>
          </div>
        </div>
        <MarkdownItVue class="md-body nippo__article" :content="this.script" />
        <div class="nippo__bottom">
          <div class="nippo__tags">
            <ul class="nippo__tag-lists">
              <li class="nippo__tag" v-for="tag in this.tags" :key="tag.id">{{tag.name}}</li>
            </ul>
          </div>
          <div class="nippo__like">
            <div
              class="heart"
              @click="handleClick()"
              :class="{unlikedHeart:!liked, likedHeart:liked, liked:liked} "
            ></div>
            <p class="nippo__likes">{{this.likes}}</p>
          </div>
        </div>
      </div>
    </div>
  </article>
</template>

<script>
import MarkdownItVue from "markdown-it-vue";
import "markdown-it-vue/dist/markdown-it-vue.css";
import Tag from "~/components/Tag.vue";
export default {
  components: {
    MarkdownItVue,
    Tag
  },
  props: [
    "author",
    "date",
    "script",
    "time",
    "title",
    "id",
    "articleId",
    "likes",
    "likeList",
    "tags"
  ],
  data() {
    return {
      admin: false,
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
      liked: false,
      requesting: false
    };
  },
  methods: {
    /*
    いいねボタン処理
     */
    async handleClick() {
      if (this.isRequesting()) return;
      this.requesting = true;

      if (!this.liked) {
        this.liked = true;
        const res = await this.$axios.post(
          "/posts/" + this.articleId + "/likes/" + this.$auth.user.id
        );
      } else {
        this.liked = false;
        const res = await this.$axios.delete(
          "/posts/" + this.articleId + "/likes/" + this.$auth.user.id
        );
      }

      this.$emit("update");
      this.requesting = false;
    },

    /*
    ストア内に編集データを送信/エディーターページに移行
    */
    editPost() {
      this.$store.commit("setDraft", this.script);
      this.$store.commit("setDraftId", this.articleId);
      this.$router.push("/editor");
    },
    /*
    指定したidの記事を削除した後、画面を更新する
     */
    async deletePost() {
      if (this.isRequesting()) return;

      this.requesting = true;
      const res = await this.$axios.delete("/posts/" + this.articleId);
      this.$emit("update");
      alert("日報を削除しました٩( 'ω' )");
      this.requesting = false;
    },

    /*
    idの倍数に応じてアイコンを返す
     */
    getIcon() {
      if (this.id % 5 == 0) {
        return this.icons[0].image;
      } else if (this.id % 4 == 0) {
        return this.icons[1].image;
      } else if (this.id % 3 == 0) {
        return this.icons[2].image;
      } else if (this.id % 2 == 0) {
        return this.icons[3].image;
      } else {
        return this.icons[4].image;
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
    }
  },

  /*
　記事がログインユーザーのidと一致すれば編集,削除ボタンを表示する。
  */
  created: function() {
    if (this.$auth.user.id == this.id) this.admin = true;
    /* const res = await this.$axios.get() */
    if (this.likeList.length != 0 || this.likeList != undefined) {
      for (let i = 0; i < this.likeList.length; i++) {
        if (this.$auth.user.id == this.likeList[i].user_id) {
          this.liked = true;
        }
      }
    }
  }
};
</script>

<style lang="scss" scoped>
$tab: 993px;
$sm: 614px;
$xsm: 528px;
$phone: 411px;
$mobile: 376px;

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

.nippo {
  padding: 10px;
  border: 1px solid #fafafa;
  background-color: white;
  border-radius: 10px;
  text-align: left;
  @include tab {
    max-width: 100%;
    margin-right: 8px;
  }

  @include xsm {
    margin-right: 0;
  }
  // box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
  &__wrapper {
    display: flex;
  }

  &__user {
    width: 10%;
    text-align: center;
    &-icon {
      max-width: 44px;
    }
    @include phone {
      width: 8%;
    }
  }
  &__content {
    width: 90%;
    padding: 8px;

    @include xsm {
      padding-top: 0;
    }
  }

  &__info {
    display: flex;
    align-items: center;

    @include xsm {
      justify-content: space-around;
    }
    &:nth-child(1) time {
      margin-left: 16px;
      @include xsm {
        font-size: 14px;
        margin-left: 8px;
      }

      @include phone {
        font-size: 13px;
        margin-left: 0;
        margin-top: 8px;
      }
    }
  }

  &__article {
    padding-top: 14px;
  }

  &__user-link {
    text-decoration: none;
    color: #24292d;
    font-weight: bold;
    &:hover {
      transition: 0.3s;
      color: #337ab7;
      cursor: pointer;
    }

    @include phone {
      font-size: 14px;
    }
  }

  &__tag-lists {
    display: flex;
    list-style: none;
  }

  &__tag {
    margin-top: 14px;
    font-size: 14px;
    display: inline-block;
    background-color: #eee;
    padding: 5px 10px;
    margin-left: 8px;
    border-radius: 6px;
    cursor: pointer;
    &:nth-child(1) {
      margin-left: 0;
    }
    &:hover {
      text-decoration: underline;
    }
  }

  &__info {
    display: flex;
    justify-content: space-between;
  }

  &__infos {
    @include phone {
      display: flex;
      flex-direction: column;
    }
  }

  &__btn {
    text-decoration: none;
    color: white;
    text-align: center;
    font-weight: 600;
    border-radius: 6px;
    display: block;
    margin-right: 8px;
    padding: 5px 5px;
    line-height: 2;
    font-size: 10px;
    width: 56px;

    @include xsm {
      padding: 5px 0;
      width: 40px;
    }

    &:hover {
      opacity: 0.7;
      transition: 0.3s;
    }

    &:nth-child(2) {
      margin-right: 0;
    }

    &-icon {
      font-size: 15px;

      @include xsm {
        font-size: 13px;
      }
    }
  }

  &__change {
    display: flex;
  }

  &__bottom {
    display: flex;
    position: relative;
    justify-content: space-between;
    align-items: center;
  }

  &__likes {
    margin-left: 4px;
    color: #758795;
    display: inline-block;
  }

  &__heart {
    position: relative;
    &:after {
      position: absolute;
      margin-left: 2px;
      content: "いいね";
      width: 120px;
      height: 20px;
      color: #758795;
    }
  }
  &__like {
    display: flex;
    align-items: center;
    position: relative;
    top: 10px;
    right: 45px;
    @include phone {
      font-size: 14px;
      right: 40px;
    }
  }

  &__likes {
    position: absolute;
    right: -115px;
    top: 16px;
    display: flex;
    margin-left: 2px;
    &:after {
      content: "いいね";
      display: inline-block;
      width: 120px;
      height: auto;
    }

    @include phone {
      font-size: 14px;
      left: 38px;
      margin-left: -3px;
    }
  }
}

.btn--edit {
  background-color: #65c97a;
}
.btn--delete {
  background-color: #d75946;
}

.md-body {
  font-size: 14px;

  @include tab {
    font-size: 14px;
  }
  @include phone {
    font-size: 11px;
  }
}

.liked {
  background-position: right !important;
}

.notLiked {
  color: #8e9aa5;
}

.heart {
  cursor: pointer;
  height: 50px;
  width: 50px;
  background-image: url("https://abs.twimg.com/a/1446542199/img/t1/web_heart_animation.png");
  background-position: left;
  background-repeat: no-repeat;
  background-size: 2900%;
}

.heart:hover {
  background-position: right;
}

.is_animating {
  animation: heart-burst 0.8s steps(28) 1;
}

.likedHeart {
  animation: heart-burst 0.8s steps(28) 1;
}

@keyframes heart-burst {
  from {
    background-position: left;
  }
  to {
    background-position: right;
  }
}
</style>


<style lang="css">
.VueStar__decoration {
  background: none;
}
</style>
