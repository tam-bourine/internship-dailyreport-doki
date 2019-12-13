<template>
  <section class="user">
    <div class="user__wrapper">
      <div class="user__left">
        <img src="../../assets/img/nippo__icon.svg" alt class="user__img" />
        <h2 class="user__name">{{this.articles.author}}manaki ikeda</h2>
        <p class="user__description">文学部専攻の大学3回生です</p>
      </div>

      <div class="user__center">
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

      <div class="user__right">
        <Nippo
          class="user__card"
          v-for="nippo in articles"
          :key="nippo.date"
          :time="nippo.time"
          :author="nippo.author"
          :script="nippo.script"
        />
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
    let userPost = await this.$axios.get(
      "http://localhost:5000/api/posts/" + this.$route.params.user
    );
    this.articles = userPost.data;
  },
  data() {
    return {
      root: this.$route.params.user,
      articles: [],
      name: "manaki"
    };
  },

  methods: {}
};
</script>

<style lang="scss" scoped>
.user {
  background-color: #eee;
  &__wrapper {
    max-width: 1040px;
    margin: 0 auto;
    display: flex;
    padding-top: 77px;
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
  }

  &__name {
    margin-top: 16px;
    font-size: 24px;
    font-weight: 300;
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