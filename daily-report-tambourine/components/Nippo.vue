<template>
  <article class="nippo">
    <div class="nippo__wrapper">
      <div class="nippo__user">
        <img src alt class="nippo__user-icon" />
        <p class="nippo__user-name"></p>
      </div>
      <p>投稿者 {{this.author}}</p>
      <time>日付 {{this.time}}</time>
      <p>タイトル:{{this.title}}</p>
      <MarkdownItVue class="md-body nippo__article" :content="this.script" />
    </div>
  </article>
</template>

<script>
import MarkdownItVue from "markdown-it-vue";
import "markdown-it-vue/dist/markdown-it-vue.css";

export default {
  components: {
    MarkdownItVue
  },

  props: ["author", "date", "script", "time", "title"],

  data() {
    return {};
  }
};
</script>

<style lang="scss" scoped>
.nippo {
  max-width: 500px;
  padding: 10px;
  margin: 0 auto;
  border: 1px solid #fafafa;
  background-color: white;
  border-radius: 10px;
  text-align: left;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);

  &__wrapper {
  }
}
</style>