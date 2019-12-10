<template>
  <div style="padding-top:100px;">
    <h2>Welcome {{$route.params.id}}</h2>
  </div>
</template>

<script>
export default {
  data() {
    return {
      root: this.$route.params.id
    };
  },

  methods: {}
};
</script>

<style lang="scss" scoped>
</style>