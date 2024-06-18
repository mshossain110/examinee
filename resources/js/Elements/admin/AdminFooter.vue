<template>
  <footer :class="footerClass">

    <div class="border-t py-4" :class="borderClass">
        <div class="text-center">
          <GHButtons
            show-follow
            show-star
            show-fork
            show-issue
            show-watch
            show-sponsor
            show-download
            show-count
            show-tips
          />
        </div>
      <p
        class="text-center text-sm leading-6 text-slate-500 dark:text-gray-300"
      >
        &copy; {{ theYear }} {{ company }}. All rights reserved.
      </p>
    </div>
  </footer>
</template>

<script>
import GHButtons from '@/Elements/admin/GHButtons.vue';
export default {
  name: 'AdminFooter',
  components: {
    GHButtons
  },
  props: {
    footerClass: {
      type: String,
      default: 'max-w-container mx-auto mt-32 w-full px-4 sm:px-6 lg:px-8',
    },
    borderClass: {
      type: String,
      default: 'border-slate-900/5 dark:border-slate-700',
    },
  },
  setup() {
    return {};
  },
  data() {
    return {
      company: 'Examinee',
    };
  },
  computed: {
    theYear() {
      const startYear = '2022';
      const currentYear = new Date().getFullYear();
      if (currentYear == startYear) {
        return currentYear;
      }
      return `${startYear}-${currentYear}`;
    },
  },
  watch: {},
  created() {},
  mounted() {},
  beforeUnmount() {},
  updated() {},
  methods: {},
};
</script>

<style scoped></style>

<style lang="scss" scoped></style>
