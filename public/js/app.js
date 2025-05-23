new Vue({
  el: '#app',
  data: {
    title: 'Chào mừng đến với Vue.js!',
    message: 'Đây là một ví dụ cơ bản sử dụng Vue.js.'
  },
  methods: {
    changeMessage() {
      this.message = 'Thông điệp đã thay đổi! Bạn đã nhấn nút.';
    }
  }
});