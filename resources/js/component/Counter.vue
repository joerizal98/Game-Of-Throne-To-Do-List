<template>
  <div class="flex items-center justify-center h-screen">
    <div class="bg-black text-white p-8 rounded-md">
      <p>{{ quote }}</p>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: "test",
  data() {
    return {
      quote: ""
    };
  },
  mounted() {
    this.fetchQuote();
  },
  methods: {
    fetchQuote() {
      axios.get("https://api.gameofthronesquotes.xyz/v1/random")
        .then(response => {
          this.quote = response.data.sentence;
        })
        .catch(error => {
          console.error("Error fetching quote:", error);
        });
    }
  }
};
</script>

<style scoped>
</style>
