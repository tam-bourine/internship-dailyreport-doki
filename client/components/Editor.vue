<template>
  <section id="editor" class="editor">
    <div class="editor__wrapper">
      <input
        class="editor__tag editor__input"
        type="text"
        v-model="tag"
        placeholder="報告の内容に関連するタグをスペース区切りで3つまで入力(例: Html CSS Javascript"
      />
      <div class="editor__content">
        <div
          class="editor__script"
          v-if="!leftScale"
          :class="{scale:rightScale,unscale:!rightScale}"
        >
          <div class="editor__bar">
            <div class="editor__bar-left">
              <p class="editor__bar-title">本文</p>
              <a
                class="editor__bar-link"
                　href="https://01intern.com/magazine/archives/15251"
                target="_blank"
              >良い日報を書くためには</a>
            </div>

            <div class="editor__bar-right">
              <a>
                <font-awesome-icon class="editor__bar-icon" icon="image" />
              </a>

              <a href="https://gist.github.com/rxaviers/7360908" target="_blank">
                <font-awesome-icon class="editor__bar-icon" icon="smile-beam" />
              </a>

              <a
                href="https://qiita.com/Minalinsky_1911/items/b684cfabe0f2fde0c67b"
                target="_blank"
                class="editor__icon-question"
              >
                <font-awesome-icon class="editor__bar-icon" icon="question-circle" />
              </a>

              <a @click.prevent="scaleRight()">
                <font-awesome-icon v-if="rightScale" class="editor__bar-icon" icon="arrow-left" />
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
            placeholder="今日の日報をMarkdown記法で書いて共有しよう！
<見出し>
# 見出し 1
## 見出し 2
### 見出し 3

<強調>
**強調**

<リンク>
[テキスト](URL)

<コード>
```javascript
let welcome =“welcome”;
console.log(welcome);
```

<リスト>
- 1
- 2
- 3
"
          ></textarea>
        </div>

        <!--
        -->
        <!-- End of editor script -->
        <div
          class="editor__preview"
          :class="{scale:leftScale,unscale:!leftScale}"
          v-if="!rightScale"
        >
          <div class="editor__bar">
            <div class="editor__bar-right">
              <a @click.prevent="scaleLeft()">
                <font-awesome-icon v-if="!leftScale" class="editor__bar-icon" icon="arrow-left" />
                <font-awesome-icon v-else class="editor__bar-icon" icon="arrow-right" />
              </a>
              <a>
                <font-awesome-icon
                  v-if="!leftScale"
                  class="editor__bar-icon"
                  icon="arrow-right"
                  @click.prevent="scaleRight()"
                />
              </a>
            </div>
          </div>
          <div class="editor__helper" v-if="!this.script">
            <p class="editor__helper-text">
              <ul>
                  <li class='editor__icon'>
                  <font-awesome-icon icon="question-circle"></font-awesome-icon>マークダウンの書き方
                  </li>
                     <li class='editor__icon'>
                  <font-awesome-icon icon="smile-beam"></font-awesome-icon>使用できる絵文字
                  </li>
              </ul>

            </p>
          </div>
          <MarkdownItVue class="md-body editor__preview-render" :content="this.script" />
        </div>
        <!-- End of preview -->
      </div>

      <!-- Editor Content -->
    </div>
    <div class="editor__footer">
      <div class="editor__footer-btns">
        <!--  v-if -->

        <a class="editor__footer-btn" v-if="this.selected==0" @click.prevent="saveNippo()">
          <font-awesome-icon icon="save" style="margin-right:6px" class="editor__footer-icon"></font-awesome-icon>下書き保存
        </a>
        <a class="editor__footer-btn" v-if="this.selected==2" @click.prevent="postNippo()">
          <font-awesome-icon icon="upload" style="margin-right:6px" class="editor__footer-icon"></font-awesome-icon>日報を投稿
        </a>
                <a class="editor__footer-btn" v-if="this.selected==1" @click.prevent="updateNippo()">
          <font-awesome-icon icon="download" style="margin-right:6px" class="editor__footer-icon"></font-awesome-icon>日報を更新
        </a>
        <!-- v-if end -->

        <a class="editor__footer-btn icon--small clicked" @click="showMenu=!showMenu">
          <span :class="{clicked:!showMenu,unClicked:showMenu}">▼</span>
          <div class="editor__menu visible" v-if="showMenu">
            <ul class="editor__lists">

              <li class="editor__list" @click.prevent="selected =1" :class="{editOff:!edit}">
                <font-awesome-icon icon="download" class="editor__list-icon"></font-awesome-icon>日報を更新
              </li>
              <li class="editor__list" @click.prevent="selected = 0">
                <font-awesome-icon icon="save" class="editor__list-icon"></font-awesome-icon>下書き保存
              </li>
                <li class="editor__list active" @click.prevent="selected=2">
                <font-awesome-icon icon="upload" class="editor__list-icon"></font-awesome-icon>日報を投稿
              </li>
            </ul>
          </div>
        </a>
      </div>

    </div>

    <!-- Editor Wrapper -->
  </section>
</template>

<script>
import MarkdownItVue from "markdown-it-vue";
import "markdown-it-vue/dist/markdown-it-vue.css";
import VueStar from 'vue-star';

export default {
  components: {
    MarkdownItVue,VueStar
  },
  data() {
    return {
      script: "",
      tag: "",
      user: this.$auth.user,
      showMenu: false,
      leftScale: false,
      rightScale: false,
      selected: 2,
      user: this.$auth.user,
      edit:false,
      requesting:false
    };
  },

  methods: {
    /*
    日報を投稿する。日報が空の場合は送信しない。
    サーバーエラー発生時にアラートを表示。
    */
    async postNippo() {
        if(this.isRequesting()) return;

        if(this.script == ''　) {
            alert('何か書いてください！(# ﾟДﾟ)')
            return;
        } else if(this.tag == '' ) {
            alert("タグが入力されていませんよ！(ﾉﾟοﾟ)ﾉ ")
            return;
        }
        this.requesting = true;
        try{
        var userId = await this.$axios.post("/posts", {
            name: this.user.name,
            body: this.script,
            tag:this.tag
      });
        }catch(error) {
            alert("サーバー側でエラーが発生している可能性があります(´・ω・`) しばらく待ってからもう一度試してみてください！");

        }

       await this.postTag(userId.data);
       this.requesting = false;
       alert('お疲れ様でした(o・ω・o)ゝ日報が投稿されましたよ！');
        this.$router.push('/home');
    },

    /*
    読み込んだ日報を更新後にユーザーページに移行。日報が空の場合は送信しない。
    サーバーエラー発生時にアラートを表示。
    */
    async updateNippo() {
        if(this.isRequesting()) return;

          if(this.script == '') {
            alert('何か書いてください！(# ﾟДﾟ)')
            return;
        }
        this.requesting = true;

        try{
            const res = await this.$axios.put('/posts/'+this.$store.getters.getDraftId, {
                id:this.$auth.user.id,
                body:this.script,
                tag:this.tag
        });
        }catch(error){
            alert("サーバー側でエラーが発生している可能性があります(´・ω・`)¥n しばらく待ってからもう一度試してみてください！");
            return;
        }
        this.requesting =false;
         alert('お疲れ様でした(o・ω・o)ゝ日報が更新されましたよ！');

        this.$store.commit('setDraft','');
        this.$store.commit('setDraftId',undefined);
        this.$router.push('/user/'+this.$auth.user.id);
    },


    /*
    日報の下書きを保存する。
    */
    saveNippo()
    {
        this.$store.commit('setDraft',this.script);
        alert('あなたの働きを保存しました∠(｀・ω・´)/')
    },

        /*
    Apiリクエスト中であれば新しいリクエストを無視する
    連打防止用
     */
    isRequesting() {
      if (this.requesting) {
        alert("すでにリクエストを送っています！しばらくお待ちください(´·ω·`)");
        return true;
      } else {
        return false;
      }
    },


    async postTag(nippoId) {
        let tagList = this.tag.split(' ');
        tagList = tagList.slice(0,3);
        console.log(tagList);
        const res =  await this.$axios.post("/posts/"+nippoId+"/tags",{
            tags:tagList
        });

    },
    /*
    右メニューを拡大。
    */
    scaleLeft() {
      this.leftScale = !this.leftScale;
    },

    /*
    左メニューを拡大。
    */
    scaleRight() {
      this.rightScale = !this.rightScale;
    }


  },
  /*
  下書きを読み込み、ストア内編集idに値があれば編集モードONにする。
  */
  created: function() {
    this.script = this.$store.getters.getDraft;
    if (this.$store.getters.getDraftId != undefined) {
        this.edit = true;
        this.selected = 1;
        }
  },

    /*
    ページ移行前に下書きを保存しておく。
    */
    beforeRouteLeave:function() {
        this.$store.commit('setDraft',this.script);
    }

};
</script>

<style lang="scss" scoped>
$tab: 787px;
$sm:727px;
$xs:528px;


@mixin tab {
  @media (max-width: ($tab)) {
    @content;
  }
}

@mixin sm {
    @media (max-width:($sm)) {
        @content;
    }
}

@mixin xs {
    @media (max-width:($xs)) {
        @content;
    }
}


input[type="text"],
input[type="password"],
textarea,
select {
  outline: 0;
}
a:hover {
  cursor: pointer;
}

.editor {
  background-color: #f7f7f7;
  position: absolute;
  left: 0;
  top: 49px;
  right: 0;
  bottom: 0;
  z-index: 0;
  overflow: hidden;
  &__wrapper {
    padding: 12px;
    max-width: 100%;
    height: 88%;
  }
  &__input {
    border-radius: 10px;
    width: 100%;
    display: block;
    padding: 8px;
    border: 1px solid #ddd;
    &:nth-child(2) {
      margin-top: 10px;
    }

  }

  &__title {
    font-size: 20px;
  }

  &__tag {
    font-size: 14px;
    @include xs {
        font-size:12px;
    }
  }

  &__content {
    display: flex;
    margin-top: 16px;
    width: 100%;
    height: 100%;
    border: 1px solid #ddd;
    border-bottom: none;
  }

  &__script-input {
    width: 100%;
    height: 100%;
    resize: none;
    border: 0;
    padding: 16px;
    font-size: 14px;
    font-family: "Noto Sans JP", sans-serif;
    //border-top: 8px solid #97caef;
  }

  &__script {
    width: 50%;
    margin-right: 8px;
  }

  &__preview {
    width: 50%;
    position: relative;
  }

  &__preview-render {
    padding: 16px;
    width: 100%;

    height: 100%;
    background-color: #fff;
    overflow: auto;
    font-family: "Noto Sans JP", sans-serif;
  }

  &__bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    height: 29px;
  }
  &__bar-left {
    display: flex;
    background-color: #f7f7f7;
    @include xs {
        display: none;
    }
  }

  &__bar-right {

    padding-left: 8px;
    @include xs {
        &:nth-child(2) {
        }
    }
  }

  &__bar-title {
    font-size: 13px;
    color: #999999;
    background-color: white;
    padding: 8px 24px;
    @include sm {
        font-size:10px;
        padding:8px 12px;
    }
  }

  &__bar-link {
    @extend .editor__bar-title;
    background-color: #f7f7f7;
    text-decoration: none;

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

    @include tab {
        margin-right: 6px;
        font-size:16px;
    }

    @include sm {
        font-size:16px;
        margin-right: 2px;
    }

  }

  &__footer {
    display: flex;
    justify-content: flex-end;
    align-items: center;
    width: 100%;
    background-color: #f7f7f7;
    position: fixed;
    bottom: 0;
    padding: 4px;
    margin: 0 auto;
    height: 6%;
  }

  &__footer-btn {
    padding: 9px 14px;
    border-radius: 4px 0 0 4px;
    font-size: 12px;
    background-color: #5679e8;
    color: #fff;
    text-decoration: none;
    &:nth-child(2) {
      border: 1px solid black;
      padding: 11px 14px;
    }

    &:hover {
      background-color: #33488b;
      transition: 0.2s;
    }
  }

  &__menu {
    position: absolute;
    transform: rotate(180deg);
    width: 141px;
    border: 4px solid #5679e8;
    bottom: -117px;
    color: black;
    display: flex;
    widows: 100%;
    left: 10px;
    max-width: 200px;
    flex-direction: column;
    align-items: center;
  }

  &__lists {
    margin: 0 auto;
    padding: 10px 0;
    position: relative;
    &:after {
      position: absolute;
      width: 0;
      height: 0;
      border: 12px solid transparent;
      border-top: 12px solid #5679e8;
      content: "";
      right: -4px;
      bottom: -28px;
    }
  }

  &__list {
    margin: 0 auto;
    line-height: 2;
    list-style: none;
    display: inline-block;
    text-align: center;
    width: 100%;

    &:hover {
      background-color: #bbc9f5;
    }
    &-icon {
      margin-right: 5px;
    }
  }

  &__icon {
      list-style: none;
      margin-top:8px;
      &:nth-child(1) {
          margin-top:0;
      }
  }

  &__icon-question {
    position: relative;

    &:before {
      content: "";
      width: 100px;
      height: 100px;
      background-color: red;
    }
  }

  &__helper {
    background-image: url("../assets/img/editor__arrow.png");
    background-repeat: no-repeat;
    position: absolute;
    width: 50px;
    height: 50px;
    top: 30px;
    left: 20px;
    transform: rotate(-25deg);
    opacity: 0.7;
    background-size: contain;
    @include sm {
        width: 35px;
        height: 35px;
    }
  }

  &__helper-text {
    display: inline-block;
    width: 200px;
    top: 85px;
    left: 50px;
    position: absolute;
    transform: rotate(25deg);
    @include sm {
        top:70px;
        left:20px;
        font-size:14px;
    }
  }
}

.clicked {
  display: inline-block;
  transition: 0.2s;
  transform: rotate(-180deg);
}

.unClicked {
  display: inline-block;
  transition: 0.2s;
  transform: rotate(0deg);
}

.md-body {
  font-size: 14px;
  @include sm {
      font-size:10px;
  }
}

.scale {
  width: 100%;
  transition: 0.2s;
}

.unscale {
  width: 50%;
  transition: 0.2s;
}

.editOff{
    pointer-events: none;
    text-decoration: line-through;
}
</style>
