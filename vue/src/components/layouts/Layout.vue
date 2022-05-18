<template>
  <div class="AppLayout h-100">
    <Header class="d-none d-lg-block" />
    <div class="body-height" style="overflow-y: auto">
      <slot />
      <Footer />
    </div>
  </div>
</template>

<script>
import Header from "@/components/layouts/Header.vue";
import Footer from "@/components/layouts/Footer.vue";

export default {
  name: "PageLayout",
  components: {
    Header,
    Footer,
  }
};
</script>
