<template>
  <section id="editor" class="editor">
    <div class="editor__wrapper">
      <input v-model="title" class="editor__input editor__title" type="text" placeholder="タイトル" />
      <input
        class="editor__tag editor__input"
        type="text"
        v-model="tag"
        placeholder="報告の内容に関連するタグをスペース区切りで3つまで入力(例: Html CSS Javascript"
      />

      <div class="editor__content">
        <div class="editor__script">
          <div class="editor__bar">
            <div class="editor__bar-left">
              <p class="editor__bar-title">本文</p>
              <a class="editor__bar-link">良い記事を書くためには</a>
            </div>

            <div class="editor__bar-right">
              <a>
                <font-awesome-icon class="editor__bar-icon" icon="image" />
              </a>

              <a>
                <font-awesome-icon class="editor__bar-icon" icon="smile-beam" />
              </a>

              <a>
                <font-awesome-icon class="editor__bar-icon" icon="question-circle" />
              </a>
            </div>
          </div>

          <textarea
            name="script"
            class="editor__script-input"
            id="scruot"
            cols="30"
            v-model="script"
            rows="10"
            placeholder="今日の日報をMarkdown記法で書いて共有しよう"
          ></textarea>
        </div>

        <!-- End of editor script -->
        <div class="editor__preview">
          <div class="editor__bar">
            <div class="editor__bar-right">
              <a>
                <font-awesome-icon class="editor__bar-icon" icon="arrow-left" />
              </a>

              <a>
                <font-awesome-icon class="editor__bar-icon" icon="arrow-right" />
              </a>

              <a>
                <font-awesome-icon class="editor__bar-icon" icon="question-circle" />
              </a>
            </div>
            <div class="editor__bar-left">
              <p class="editor__bar-title">本文</p>
              <a class="editor__bar-link">良い記事を書くためには</a>
            </div>
          </div>
          <MarkdownItVue class="md-body editor__preview-render" :content="this.script" />
          <!-- 
          <div v-html="render()" style="background-color:#f" class="editor__preview-render"></div>
          -->
        </div>
        <!-- End of preview -->
      </div>
      <!-- Editor Content -->
    </div>
    <!-- Editor Wrapper -->

    <button @click.prevent="postDraft()">Post Request Test</button>
    <button @click.prevent="getDraft()">Get draft data</button>
  </section>
</template>

<script>
import MarkdownItVue from "markdown-it-vue";
import "markdown-it-vue/dist/markdown-it-vue.css";

export default {
  components: {
    MarkdownItVue
  },
  data() {
    return {
      script: "Welcome to daily report!!",
      title: "",
      tag: "",
      user: {
        name: "manaki"
      }
    };
  },

  methods: {
    /* Test Post request */
    async postDraft() {
      let time = new Date().toLocaleString();
      const res = await this.$axios.post(
        "https://tango-dojo-api.herokuapp.com/markdown",
        {
          draft: {
            time: time,
            script: this.script,
            tag: this.tag,
            title: this.title,
            author: this.user.name
          }
        }
      );
    },

    async getDraft() {
      const res = await this.$axios.get(
        "https://tango-dojo-api.herokuapp.com/getDraft"
      );

      console.log(res);
      this.script = res.data.script.text;
    }
  }
};
</script>

<style lang="scss" scoped>
input[type="text"],
input[type="password"],
textarea,
select {
  outline: 0;
}

.editor {
  background-color: #f7f7f7;
  top: 55px;
  position: absolute;
  width: 100%;
  &__wrapper {
    padding: 10px;
    max-width: 100%;
    max-height: 80%;
  }
  &__input {
    border-radius: 10px;
    width: 100%;
    display: block;
    padding: 10px;
    border: 1px solid #ddd;
    &:nth-child(2) {
      margin-top: 10px;
    }
  }

  &__title {
    font-size: 24px;
  }

  &__tag {
    font-size: 14px;
  }

  &__content {
    display: flex;
    margin-top: 16px;
    width: 100%;
    height: 60vh;
    max-height: 500px;
    border-radius: 20px;
  }

  &__script-input {
    width: 100%;
    height: 100%;
    resize: none;
    border: 0;
    padding: 16px;
    font-size: 16px;
    //border-top: 8px solid #97caef;
  }

  &__script {
    width: 50%;
    margin-right: 8px;
  }

  &__preview {
    width: 50%;
    height: 100%;
  }

  &__preview-render {
    padding: 16px;
    width: 100%;
    height: 100%;
    background-color: #fff;
    overflow: auto;
  }

  &__bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
  }
  &__bar-left {
    display: flex;
    background-color: #f7f7f7;
  }

  &__bar-title {
    font-size: 13px;
    color: #999999;
    background-color: white;
    padding: 8px 24px;
  }

  &__bar-link {
    @extend .editor__bar-title;
    background-color: #f7f7f7;

    &:hover {
      background-color: #999999;
      color: #fff;
    }
  }

  &__bar-icon {
    font-size: 20px;
    color: #b3b3b3;
    margin-right: 12px;
    &:hover {
      color: black;
    }
  }

  &__footer-content {
    display: flex;
    justify-content: flex-end;
    background-color: red;
  }
}
</style>