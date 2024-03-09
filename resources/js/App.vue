<template>
  <div>
    <div>
      <Bg></Bg>
    </div>
    <!-- <div class="relative z-10">
      <test></test>
    </div> -->
    <div class="relative z-10">
      <todo></todo>
    </div>
  </div>
</template>

<script>
// import test from './component/Counter.vue'
import todo from './component/TodoApp.vue'
import Bg from './component/Bg.vue'
export default {
  components: {
    // test,
    todo,
    Bg
  }
}
</script>
