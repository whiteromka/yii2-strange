<template>
  <div>
    <h2>Rom component</h2>
    <p>{{message}}</p>
    <p>{{txt}}</p>
  </div>
</template>

<script>
export default {
  name: "RomComponent",
  props: {
    message: String,
    txt: String
  }
}
</script>

<style scoped>

</style>