<template>
  <section class="home">
    <div class="home__wrapper">
      <div class="home__left">
        <ul class="home__sort">
          <li class="home__sort-list active">
            <font-awesome-icon icon="calendar-check" class="home__list-icon"></font-awesome-icon>投稿日順
          </li>

          <li class="home__sort-list">
            <font-awesome-icon icon="edit" class="home__list-icon"></font-awesome-icon>更新日順
          </li>
          <li class="home__sort-list">
            <font-awesome-icon icon="binoculars" class="home__list-icon"></font-awesome-icon>閲覧数順
          </li>
        </ul>
      </div>

      <div class="home__center">
        <Nippo
          class="home__card"
          v-for="nippo in articles"
          v-bind:key="nippo.date"
          :time="nippo.time"
          :script="nippo.script"
          :author="nippo.author"
        />
      </div>

      <div class="home__right">
        <div class="home__profile">
          <div class="home__profile-info">
            <img class="home__logo" src="../assets/img/nippo__icon.svg" alt="profile-icon" />
            <a class="home__name">
              まなきんぐ
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
      articles: []
    };
  },

  created: async function() {
    //if not logged in send user to login form or singup
    let draftData = await this.$axios.get(
      "https://tango-dojo-api.herokuapp.com/getDraft"
    );
    this.articles = draftData.data;
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

  &__right {
    margin-left: 16px;
    margin-top: 300px;
    width: 300px;
  }
  &__card {
    margin-top: 16px;
    &:nth-child(1) {
      margin-top: 0;
      border-radius: 0;
    }
  }

  &__profile {
    background-color: #fff;
    padding-top: 10px;
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
}

.active {
  background-color: #5679e8;
  color: #fff;
  &:hover {
    background-color: #33488b;
  }
}
</style>