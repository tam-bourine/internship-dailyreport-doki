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
            <time style="color:#b8b8b8">{{this.time}}</time>
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
              <li class="nippo__tag">html</li>
              <li class="nippo__tag">css</li>
              <li class="nippo__tag">javascirpt</li>
            </ul>
          </div>

          <vue-star class="nippo__like" animate="animated rubberBand" color="#F05654">
            <a slot="icon" class="fa fa-heart" @click="handleClick"></a>
          </vue-star>
        </div>
      </div>
    </div>
  </article>
</template>

<script>
import MarkdownItVue from "markdown-it-vue";
import "markdown-it-vue/dist/markdown-it-vue.css";
import VueStar from "vue-star";
export default {
  components: {
    MarkdownItVue,
    VueStar
  },
  props: ["author", "date", "script", "time", "title", "id", "articleId"],
  data() {
    return {
      admin: false,
      likes: 0,
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
      ]
    };
  },
  methods: {
    /*
    いいねボタン処理
     */
    handleClick() {
      alert("you liked ~ tweet");
    },

    /*
    ストア内に編集データを送信/エディーターページに移行
    */
    editPost() {
      this.$store.commit("setDraft", this.script);
      this.$store.commit("setDraftId", this.articleId);
      this.$router.push("editor");
    },
    /*
    指定したidの記事を削除した後、画面を更新する
     */
    async deletePost() {
      const res = await this.$axios.delete("/posts/" + this.articleId);
      this.$emit("update");
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
    }
  },

  /*
　記事がログインユーザーのidと一致すれば編集,削除ボタンを表示する。
  */
  created: function() {
    if (this.$auth.user.id == this.id) this.admin = true;
    /* const res = await this.$axios.get() */
  }
};
</script>

<style lang="scss" scoped>
$tab: 993px;
$sm: 614px;
$xsm: 528px;
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

.nippo {
  max-width: 560px;
  padding: 10px;
  border: 1px solid #fafafa;
  background-color: white;
  border-radius: 10px;
  text-align: left;
  @include tab {
    max-width: 100%;
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

  &__like {
    right: 20px;
    bottom: -45px;
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
}
</style>
