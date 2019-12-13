<template>
  <article class="nippo">
    <div class="nippo__wrapper">
      <div class="nippo__user">
        <img src="../assets/img/nippo__icon.svg" alt="user-icon" class="nippo__user-icon" />
      </div>

      <div class="nippo__content">
        <div class="nippo__info">
          <a class="nippo__user-link">{{this.author}}</a>
          <time style="color:#b8b8b8">{{this.time}}</time>
        </div>
        <MarkdownItVue class="md-body nippo__article" :content="this.script" />
        <div class="nippo__tags">
          <ul class="nippo__tag-lists">
            <a class="nippo__tag">php</a>
            <a class="nippo__tag">html</a>
            <a class="nippo__tag">css</a>
          </ul>
        </div>
      </div>
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
  // box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
  &__wrapper {
    display: flex;
  }

  &__user {
    width: 10%;
    text-align: center;
    &-icon {
      max-width: 50px;
    }
  }
  &__content {
    width: 80%;
    padding: 8px;
  }

  &__info {
    display: flex;
    align-items: center;
    &:nth-child(1) time {
      margin-left: 16px;
    }
  }

  &__article {
    padding-top: 14px;
  }

  &__user-link {
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
}

.md-body {
  font-size: 14px;
}
</style>