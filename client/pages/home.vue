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
      </div>

      <div class="home__center">
        <Nippo
          class="home__card"
          v-for="nippo in this.articles"
          v-bind:key="nippo.id"
          :time="nippo.created_at"
          :script="nippo.body"
          :author="nippo.user_id"
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
            <img class="home__logo" src="../assets/img/nippo__icon.svg" alt="profile-icon" />
            <a class="home__name">
              manaki/ikeda
              <br />
              <pre class="home__id">@manaki</pre>
            </a>
          </div>
          <div class="home__boxes">
            <div class="home__box">
              <a class="home__number">0</a>
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
export default {
  components: {
    Nippo
  },

  data() {
    return {
      user: true,
      articles: [],
      listActive: [true, false, false]
    };
  },

  created: async function() {
    //if not logged in send user to login form or singup
    let draftData = await this.$axios.get("/posts");
    this.articles = draftData.data;
    console.log(this.articles);
    this.articles = this.sortByLatest();
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
    }
  }
};
</script>

<style lang="scss" scoped>
html,
body {
  background-color: #eee;
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
  }

  &__title {
    font-size: 32px;
  }

  &__center {
    width: 580px;
  }

  &__right {
    margin-left: 16px;
    width: 300px;
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
    width: 200px;
  }

  &__sort-list {
    display: inline-block;
    list-style: none;
    padding: 10px 40px;
    font-size: 12px;
    cursor: pointer;
    margin-top: 8px;

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
