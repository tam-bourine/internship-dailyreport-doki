<template>
  <a @click="click()" :class="{clicked:clicked}">{{this.name}}</a>
</template>

<script>
export default {
  props: ["name", "tagSelected"],
  data() {
    return {
      clicked: false
    };
  },
  methods: {
    click() {
      this.clicked = !this.clicked;
      if (this.clicked) {
        this.$parent.tagSelected.push(this.name);
      } else {
        this.$parent.tagSelected = this.$parent.tagSelected.filter(
          n => n != this.name
        );
      }
    }
  }
};
</script>

<style lang="scss">
.tag {
  background-color: #fff;
  position: relative;
  padding: 5px 10px;
  margin-top: 8px;
  display: inline-block;
  z-index: 1;
  border-radius: 5px 0 0 5px;
  margin-left: 8px;

  &:before {
    z-index: -4;
    position: absolute;
    content: "";
    width: 15px;
    height: 15px;
    top: 3px;
    left: -6px;
    transform: rotate(45deg);
    background-color: #fff;
  }
}

.clicked {
  background-color: #5679e8 !important;
  color: #fff;

  &:before {
    background-color: #5679e8 !important;
  }
}
</style>
