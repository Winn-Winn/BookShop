<template>
    <footer class="bg-white text-center footer-height">
        <div class="container h-100">
            <span>CopyRight&copy; All Rights Reserved.</span>
        </div>
    </footer>
</template>
<script>
export default {
  name: "FooterPart",
  data() {
    return { visible: false };
  },
  methods: {
    scrollTop: function () {
      let app = document.getElementById("app");
      console.log(app.scrollHeight);
      this.intervalId = setInterval(() => {
        if (window.pageYOffset === 0) {
          clearInterval(this.intervalId);
        }
        window.scroll(0, window.pageYOffset - 50);
      }, 20);
    },
    scrollListener: function () {
      console.log(window.scrollY);
      this.visible = window.scrollY > 150;
    },
  },
  computed: {
  },
};
</script>
