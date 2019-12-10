<template>
  <div style="padding-top:100px;">
    <h2>Welcome {{this.root}}</h2>
  </div>
</template>

<script>
export default {
  data() {
    return {
      root: this.$route.query.id
    };
  }
};
</script>

<style lang="scss" scoped>
</style>