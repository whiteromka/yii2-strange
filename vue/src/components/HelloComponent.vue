<template>
    <div>
      <h1>{{ msg }}</h1>
      <p>it is from hello-component </p>
      <rom-component
          :message="msg"
          :txt="txt"
      >
      </rom-component>
    </div>
</template>

<script>
import RomComponent from "@/components/RomComponent";
export default {
  name: 'HelloComponent',
  components: {RomComponent},
  props: {
    msg: String
  },
  data() {
    return {
      txt: 'Это свойство из компонента'
    }
  }
}
</script>

<style scoped>
h1 {
  cursor: pointer;
  margin: 40px 0 0;
}
</style>
