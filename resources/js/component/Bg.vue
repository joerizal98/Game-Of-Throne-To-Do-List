<template>
  <div class="fixed inset-0 z-0 bg-cover" :style="{ backgroundImage: `url(${bgImage})` }">
  </div>
</template>

<script>
export default {
  name: "Bg",
  data() {
    return {
      bgImage: "" 
    };
  },
  mounted() {
    this.fetchWallpaper();
  },
  methods: {
    fetchWallpaper() {
      fetch("/api/wall")
        .then(response => response.json())
        .then(data => {
          if (data.status === 200 && data.api) {
            this.bgImage = `data:image/jpeg;base64,${data.api.image_data}`;
          } else {
            console.error("No wallpaper found");
          }
        })
        .catch(error => {
          console.error("Error fetching wallpaper:", error);
        });
    }
  }
};
</script>

<style scoped>
</style>
