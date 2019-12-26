<template>
  <section class="home">
    <div class="home__wrapper">
      <div class="home__left">
        <ul class="home__sort">
          <li
            class="home__sort-list"
            :class="{active: listActive[0]}"
            @click.prevent="sortByLatest(); switchActiveList(0)"
          >
            <font-awesome-icon icon="calendar-check" class="home__list-icon"></font-awesome-icon>投稿日順
          </li>

          <li
            class="home__sort-list"
            :class="{active:listActive[1]}"
            　@click.prevent="sortByUpdated(); switchActiveList(1)"
            　
          >
            <font-awesome-icon icon="edit" class="home__list-icon"></font-awesome-icon>更新日順
          </li>
          <li
            class="home__sort-list"
            :class="{active:listActive[2]}"
            @click.prevent="sortByOldest(); switchActiveList(2)"
          >
            <font-awesome-icon icon="binoculars" class="home__list-icon"></font-awesome-icon>古い物順
          </li>
        </ul>

        <ul class="home__tags">
          <li class="home__tag" v-for="tag in tagList" :key="tag.id">
            <Tag
              :name="tag.name"
              :tagSelected="tagSelected"
              @update="addTagSelected,removeTagSelected"
              class="home__tag-link"
            ></Tag>
          </li>
        </ul>
      </div>
      <div class="home__center">
        <Nippo
          @update="updateList"
          class="home__card"
          v-for="nippo in this.articles"
          v-bind:key="nippo.id"
          :time="nippo.created_at"
          :script="nippo.body"
          :author="nippo.user.name"
          :id="nippo.user_id"
          :articleId="nippo.id"
          :likes="nippo.likes.length"
          :likeList="nippo.likes"
          :tags="nippo.tags"
        />
      </div>

      <div class="home__right">
        <div class="home__ad">
          <a href="https://www.tam-bourine.co.jp/" target="_blank">
            <img src="../assets/img/home__img.jpg" alt="company-ad" class="home__ad-img" />
          </a>
        </div>

        <div class="home__profile">
          <div class="home__profile-info">
            <img class="home__logo" :src="getIcon()" alt="profile-icon" />
            <a class="home__name">
              {{this.$auth.user.name}}
              <br />
              <pre class="home__id">@tambourine</pre>
            </a>
          </div>
          <div class="home__boxes">
            <div class="home__box">
              <nuxt-link
                class="home__number"
                :to="{name:'user-user',params:{user:this.$auth.user.id}}"
              >{{this.nippoAmount}}</nuxt-link>
              <p class="home__category">日報</p>
            </div>
            <div class="home__box">
              <a class="home__number">0</a>
              <p class="home__category">フォロー</p>
            </div>

            <div class="home__box">
              <a class="home__number">0</a>
              <p class="home__category">いいね</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import Nippo from "@/components/Nippo.vue";
import Tag from "@/components/Tag.vue";
export default {
  components: {
    Nippo,
    Tag
  },

  data() {
    return {
      user: true,
      articles: [],
      articlesBackUp: [],
      tagList: [],
      listActive: [true, false, false],
      nippoAmount: 0,
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
      requesting: false,
      tagSelected: []
    };
  },

  /*
　最新の記事を取得、ユーザーの記事数をセット
  */
  created: async function() {
    this.updateList();
    const nippo = await this.$axios.get("/posts/" + this.$auth.user.id);
    const tags = await this.$axios.get("/tags");
    this.tagList = tags.data;
    this.nippoAmount = nippo.data.length;
  },

  methods: {
    /*
    記事を新しい順に並び替え
    */
    sortByLatest() {
      return this.articles.sort((a, b) => {
        return a.created_at < b.created_at ? 1 : -1;
      });
    },

    /*
    記事を更新順に並び替え
    */
    sortByUpdated() {
      return this.articles.sort((a, b) => {
        return a.updated_at < b.updated_at ? 1 : -1;
      });
    },
    /*
    記事を古い順に並び替え
    */
    sortByOldest() {
      return this.articles.sort((a, b) => {
        return a.created_at > b.created_at ? 1 : -1;
      });
    },

    /*
    並び替え機能の切り替え
    */
    switchActiveList(listIndex) {
      this.listActive = [false, false, false];
      this.listActive[listIndex] = true;
    },

    /*
    データベースから最新の投稿データを取得
     */
    async updateList() {
      let nippoData = await this.$axios.get("/posts");
      this.articles = nippoData.data;
      this.articlesBackUp = nippoData.data;
      this.articles = this.sortByLatest();
    },

    /*
    指定した要素をタグ選択リストに追加
    */
    addTagSelected(tag) {
      this.tagSelected.push(tag);
    },

    /*
    指定されたタグをタグ選択リストから取り除く
     */
    removeTagSelected(tag) {
      this.tagSelected = this.tagSelected.filter(n => n == tag);
    },

    /*
    指定したタグを持った記事を抽出
    */
    filterTag(tag) {
      this.articles = this.articles.filter(value => {
        return value == tag;
      });
    },
    getIcon() {
      console.log(this.$auth.user.id);
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

  watch: {
    tagSelected: function() {
      let tempList = [];
      if (this.tagSelected.length == 0) {
        this.articles = this.articlesBackUp;
        console.log(this.articles);
        return;
      }

      for (let tagIndex in this.tagSelected) {
        for (let articleIndex in this.articlesBackUp) {
          for (let tagIndex2 in this.articlesBackUp[articleIndex].tags) {
            if (
              this.articlesBackUp[articleIndex].tags[tagIndex2].name ==
              this.tagSelected[tagIndex]
            ) {
              if (!tempList.includes(this.articlesBackUp[articleIndex])) {
                tempList.push(this.articlesBackUp[articleIndex]);
              }
            }
          }
        }
      }
      this.articles = tempList;
    }
  }
};
</script>

<style lang="scss" scoped>
html,
body {
  background-color: #eee;
}

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
  @media (min-width: ($phone)) {
    @content;
  }
}

.home {
  background-color: #eee;
  &__wrapper {
    padding-top: 57px+ 20px;
    max-width: 1040px;
    margin: 0 auto;
    text-align: center;
    padding-bottom: 100px;
    display: flex;
    @include sm {
      overflow: hidden;
    }
  }

  &__title {
    font-size: 32px;
  }

  &__center {
    width: 580px;
    @include tab {
      width: 70%;
    }

    @include sm {
      width: 68%;
    }

    @include xsm {
      margin: 0 auto;
      width: 90%;
    }
  }

  &__left {
    @include xsm {
      display: none;
    }
  }
  &__right {
    margin-left: 16px;
    width: 300px;
    @include tab {
      display: none;
    }
  }
  &__card {
    margin-top: 16px;
    &:nth-child(1) {
      margin-top: 0;
    }
  }

  &__profile {
    margin-top: 20px;
    background-color: #fff;
    padding-top: 16px;
  }

  &__sort {
    position: sticky;
    top: 66px;
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    text-align: left;

    @include sm {
      width: 100%;
      text-align: center;
    }
  }

  &__tags {
    position: sticky;
    top: 180px;
    margin-top: 8px;
  }

  &__sort-list {
    display: inline-block;
    list-style: none;
    padding: 10px 40px;
    font-size: 12px;
    cursor: pointer;
    margin-top: 8px;

    @include sm {
      font-size: 12px;
      padding: 10px 30px 10px 20px;
    }

    &:hover {
      transition: 0.3s;

      background-color: #b8b8b8;
    }
    &:nth-child(1) {
      margin-top: 0;
    }
  }
  &__name {
    margin-left: 8px;
    font-weight: 700;
    cursor: pointer;
  }
  &__list-icon {
    margin-right: 8px;
  }

  &__profile-info {
    display: flex;
    align-items: center;
    padding: 8px;
    font-size: 15px;
    text-align: left;
  }

  &__logo {
    width: 48px;
    height: auto;
    margin-left: 24px;
  }

  &__boxes {
    border-top: 1px solid #ddd;
    display: flex;
  }

  &__box {
    padding: 14px 8px;
    width: 33%;
    border-right: 1px solid #ddd;
    &:nth-child(3) {
      border: none;
    }
  }

  &__number {
    font-size: 18px;
    cursor: pointer;
    color: black;
    text-decoration: none;
    display: block;
    width: 100%;
    &:hover {
      text-decoration: underline;
    }
  }

  &__category {
    font-size: 12px;
    margin-top: 4px;
  }

  &__id {
    font-size: 12px;
    font-weight: 300;
    color: #999;
    margin-top: 4px;
  }

  &__ad-img {
    max-width: 100%;
    object-fit: cover;

    &:hover {
      opacity: 0.7;
      transition: 0.4s;
    }
  }
  &__tags {
    margin-right: 14px;
    padding: 20px;
    display: gird;
    grid-gap: 8px;
    max-width: 200px;
    @include sm {
      max-width: 168px;
    }
  }

  &__tag {
    margin-top: 14px;
    font-size: 12px;
    display: inline-block;
    margin-left: 8px;
    cursor: pointer;
  }

  &__tag-link {
    position: relative;
    padding: 5px 10px;
    margin-top: 8px;
    display: inline-block;
    z-index: 1;
    border-radius: 5px 0 0 5px;
    margin-left: 8px;
    background-color: #fff;
    transition: 0.3s;

    &:hover {
      opacity: 0.8;
      transition: 0.3s;
    }
    &:before {
      z-index: -4;
      position: absolute;
      content: "";
      width: 15px;
      height: 14px;
      top: 4px;
      left: -6px;
      transform: rotate(45deg);
      background-color: #fff;
      transition: 0.3s;
    }
  }
}

.active {
  background-color: #5679e8;
  color: #fff;
  pointer-events: none;
  &:hover {
    background-color: #33488b;
  }
}
</style>
