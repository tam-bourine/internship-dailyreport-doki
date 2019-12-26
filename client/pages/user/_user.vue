<template>
  <section class="user">
    <div class="user__wrapper">
      <div class="user__left">
        <img :src="getIcon()" alt class="user__img" />
        <h2 class="user__name">{{this.name}}</h2>
        <p class="user__description" v-if="this.comment">{{this.comment}}</p>
      </div>

      <div class="user__right" v-if="!rom">
        <Nippo
          @update="updateList"
          class="user__card"
          v-for="nippo in articles"
          :key="nippo.id"
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
      <div class="user__right" v-else>
        <h2 class="user__message">(≧▽≦)つ[このユーザーはまだ日報を投稿していないよ！]</h2>
      </div>

      <div class="user__center">
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
    </div>
  </section>
</template>

<script>
import Nippo from "~/components/Nippo.vue";
import Tag from "~/components/Tag.vue";
export default {
  components: {
    Nippo,
    Tag
  },

  created: async function() {
    let userPost = await this.$axios.get("/posts/" + this.$route.params.user);
    const tags = await this.$axios.get("/tags");
    console.log(tags.data);
    this.tagList = tags.data;
    this.articles = userPost.data;
    this.articlesBackUp = userPost.data;
    //this.articles = this.sortByLatest();

    if (this.articles.length == 0) {
      this.rom = true;
      let userInfo = await this.$axios.get("users/" + this.$route.params.user);
      this.name = userInfo.data.name;
      this.comment = userInfo.data.comment;
    } else {
      this.name = this.articles[0].user.name;
      this.comment = this.articles[0].user.comment;
      this.admin = true;
    }
  },
  data() {
    return {
      root: this.$route.params.user,
      articles: [],
      name: "",
      listActive: [true, false, false],
      admin: false,
      rom: false,
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
      comment: "設定からひとことを追加しよう！",
      articlesBackUp: [],
      tagSelected: [],
      tagList: []
    };
  },

  methods: {
    /*
    記事を新しい順に並び替え
    */
    sortByLatest() {
      return this.articles.sort((a, b) => {
        return a.date < b.date ? 1 : -1;
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
        return a.date > b.date ? 1 : -1;
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
      alert("running this function");
      let draftData = await this.$axios.get("/posts/" + this.$auth.user.id);
      this.articles = draftData.data;
      this.articles = this.sortByLatest();
    },
    getIcon() {
      if (this.root % 5 == 0) {
        return this.icons[0].image;
      } else if (this.root % 4 == 0) {
        return this.icons[1].image;
      } else if (this.root % 3 == 0) {
        return this.icons[2].image;
      } else if (this.root % 2 == 0) {
        return this.icons[3].image;
      } else {
        return this.icons[4].image;
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
$tab: 993px;
$sm: 740px;
$xsm: 614px;

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

.user {
  background-color: #eee;
  &__wrapper {
    max-width: 1040px;
    margin: 0 auto;
    display: flex;
    padding: 77px 0;

    @include tab {
      margin: 0;
    }
  }
  &__left {
    width: 25%;
    background-color: #fff;
    height: 100%;
    margin-right: 16px;
    text-align: center;
    padding: 2%;
    @include tab {
      display: none;
    }
  }
  &__message {
    font-size: 20px;
    font-weight: 600;
  }
  &__right {
    width: 70%;
    @include tab {
      margin: 0;
      margin-left: 50px;
    }

    @include xsm {
      margin: 0 auto;
      width: 90%;
    }
  }
  &__center {
    @include tab {
      max-width: 70%;
    }
    @include xsm {
      display: none;
    }
  }

  &__img {
    max-width: 200px;
    border-radius: 16px;
    @include xsm {
      max-width: 72px;
      margin-right: 8px;
    }
  }

  &__description {
    font-size: 14px;
    margin-top: 8px;
    text-align: left;
    line-height: 1.3;
  }

  &__name {
    margin-top: 16px;
    font-size: 24px;
    font-weight: 300;
  }

  &__card {
    margin-top: 16px;
    &:nth-child(1) {
      margin-top: 0;
    }
  }
}

.home {
  &__sort {
    position: sticky;
    top: 66px;
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    text-align: left;
    width: 200px;

    @include sm {
      width: 150px;
    }
  }

  &__sort-list {
    display: inline-block;
    list-style: none;
    padding: 10px 40px;
    font-size: 12px;
    cursor: pointer;
    margin-top: 8px;

    @include sm {
      font-size: 10px;
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

  &__list-icon {
    margin-right: 8px;
  }

  &__tag {
    margin-top: 14px;
    font-size: 12px;
    display: inline-block;
    margin-left: 8px;
    cursor: pointer;
  }
  &__tags {
    position: sticky;
    top: 180px;
    margin-top: 8px;
    margin-right: 14px;
    padding: 20px;
    display: gird;
    grid-gap: 8px;
    max-width: 200px;
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
