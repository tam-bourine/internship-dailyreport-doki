<template>
  <section class="user">
    <div class="user__wrapper">
      <div class="user__left">
        <img src="../../assets/img/nippo__icon.svg" alt class="user__img" />
        <h2 class="user__name">{{this.articles.author}}manaki ikeda</h2>
        <p class="user__description">たい焼きを食べるのが大好きな大学生です。</p>
      </div>

      <div class="user__right">
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
        />
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
      </div>
    </div>
  </section>
</template>

<script>
import Nippo from "~/components/Nippo.vue";
export default {
  components: {
    Nippo
  },

  created: async function() {
    let userPost = await this.$axios.get("/posts/" + this.$route.params.user);
    this.articles = userPost.data;
    this.articles = this.sortByLatest();
    //ログインユーザのページが開かれている場合
    this.admin = true;
  },
  data() {
    return {
      root: this.$route.params.user,
      articles: [],
      name: "manaki",
      listActive: [true, false, false],
      admin: false
    };
  },

  methods: {
    sortByLatest() {
      return this.articles.sort((a, b) => {
        return a.date < b.date ? 1 : -1;
      });
    },

    sortByUpdated() {
      return this.articles.sort((a, b) => {
        return a.updated_at < b.updated_at ? 1 : -1;
      });
    },

    sortByOldest() {
      return this.articles.sort((a, b) => {
        return a.date > b.date ? 1 : -1;
      });
    },

    switchActiveList(listIndex) {
      this.listActive = [false, false, false];
      this.listActive[listIndex] = true;
    },
    async updateList() {
      let draftData = await this.$axios.get("/posts/" + this.$auth.id);
      this.articles = draftData.data;
      this.articles = this.sortByLatest();
    }
  }
};
</script>

<style lang="scss" scoped>
.user {
  background-color: #eee;
  &__wrapper {
    max-width: 1040px;
    margin: 0 auto;
    display: flex;
    padding: 77px 0;
  }
  &__left {
    width: 30%;
    text-align: center;
    padding: 0 3% 3% 3%;
  }

  &__right {
    width: 70%;
  }

  &__img {
    max-width: 250px;
    border-radius: 16px;
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
  &__sort-list {
    display: inline-block;
    list-style: none;
    padding: 10px 40px;
    font-size: 12px;
    margin-top: 8px;

    &:hover {
      transition: 0.3s;

      background-color: #b8b8b8;
    }
    &:nth-child(1) {
      margin-top: 0;
    }
  }
  &__sort {
    position: sticky;
    top: 66px;
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    text-align: left;
    width: 200px;
  }

  &__list-icon {
    margin-right: 8px;
  }
}

.active {
  background-color: #5679e8;
  color: #fff;
  &:hover {
    background-color: #33488b;
  }
}
</style>
