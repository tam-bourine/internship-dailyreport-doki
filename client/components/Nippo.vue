<template>
  <article class="nippo">
    <div class="nippo__wrapper">
      <div class="nippo__user">
        <img src="../assets/img/nippo__icon.svg" alt="user-icon" class="nippo__user-icon" />
      </div>
      <div class="nippo__content">
        <div class="nippo__info">
          <div class="nippo__infos">
            <nuxt-link
              :to="{name: 'user-user', params: {user:author} }"
              class="nippo__user-link"
            >manaki</nuxt-link>
            <nuxt-link class="nippo__user-link" to="this.auhor">{{this.author}}</nuxt-link>
            <time style="color:#b8b8b8">{{this.time}}</time>
          </div>
          <div class="nippo__change">
            <a href class="nippo__btn btn--edit" 　@click.prevent="editPost()">
              <font-awesome-icon icon="edit" class="nippo__btn-icon"></font-awesome-icon>
            </a>
            <a href class="nippo__btn btn--delete">
              <font-awesome-icon icon="trash" class="nippo__btn-icon"></font-awesome-icon>
            </a>
          </div>
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
  },

  computed() {},
  methods: {
    editPost() {
      this.$store.commit("setDraft", this.script);
      this.$router.push("editor");
    },

    async deletePost() {
      const res = await this.$axios.delete("/posts/" + author);
    }
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
    font-size: 12px;
    width: 56px;

    &:hover {
      opacity: 0.7;
      transition: 0.3s;
    }

    &:nth-child(2) {
      margin-right: 0;
    }

    &-icon {
      font-size: 15px;
    }
  }

  &__change {
    display: flex;
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
