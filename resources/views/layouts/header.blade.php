<style>
  .user-info {
  position: relative;
  cursor: pointer;
  display: flex;
  align-items: center;
  transform: translateX(-10px);
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 10px 20px;
  background-color: #FFB405; /* nền vàng cam */
}

.logo-img {
  height: 80px;
  width: 100%;
  /* object-fit: contain; */
}
.avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  margin-right: 8px;
}

.username {
  font-weight: bold;
  color: #333;
}

.dropdown-menu {
  display: none;
  position: absolute;
  top: 100%;
  right: 0;
  background: white;
  border: 1px solid #ddd;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  border-radius: 4px;
  z-index: 100;
  min-width: 150px;
}

.dropdown-menu a {
  display: block;
  padding: 10px;
  color: #333;
  text-decoration: none;
}

.dropdown-menu a:hover {
  background-color: #f1f1f1;
}
</style>
<?php 
 $user = auth()->user();
?>
<div class="header">
  <a href="{{route('list-word')}}" class="logo">
    <img src="/images/WORDY (3).png" alt="Logo" class="logo-img">
  </a>
  <div class="user-info" onclick="toggleDropdown()">
    <img src="/images/avatar-cute-dang-iu-6.jpg" alt="Avatar" class="avatar">
    <span class="username">{{$user->full_name}}</span>
    <div class="dropdown-menu" id="dropdownMenu">
      <a href="{{route('profile')}}">Trang cá nhân</a>
      <a href="{{route('password.confirm')}}">Đổi mật khẩu</a>
      <a href="{{route('login')}}">Thoát</a>
    </div>
  </div>
</div>
<script>
  function toggleDropdown() {
    const menu = document.getElementById("dropdownMenu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  }

  // Đóng menu khi click ra ngoài
  document.addEventListener("click", function (e) {
    const userInfo = document.querySelector(".user-info");
    const dropdown = document.getElementById("dropdownMenu");
    if (!userInfo.contains(e.target)) {
      dropdown.style.display = "none";
    }
  });
</script>