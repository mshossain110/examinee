<template>
	<h1>Hello Vue</h1>
</template>

<script type="text/javascript">
	import eventHub from '../event'
	export default {
		
		mounted() {
			this.$http.get('/exam').then((response) => {
				Echo.private('exams').listen('ExamWasCreated', (e) => {

					eventHub.$emit(e);

				});
			});
		}
	}
</script>