<template>
  <section class="home">
    <div class="home__wrapper">
      <h2 class="home__title">日報リスト</h2>
      <Nippo
        class="home__card"
        v-for="nippo in articles"
        v-bind:key="nippo.date"
        :time="nippo.time"
        :script="nippo.script"
        :author="nippo.author"
        :title="nippo.title"
      />
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
  }

  &__title {
    font-size: 32px;
  }

  &__card {
    margin-top: 16px;
  }
}
</style>