@extends('layouts.app')
@section('content')
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Profile</title>

  <!-- Bootstrap & Font Awesome -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" />
  <link  href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>
  <style>
    .profile-container {
      text-align: center;
      margin-top: 20px;
      margin-left: auto;
      margin-right: auto;
      border-radius: 10px;
      padding-bottom: 20px;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .cover-photo {
      position: relative;
      border-radius: 10px 10px 0 0;
      overflow: hidden;
    }

    .cover-img {
      width: 100%;
      height: 300px !important;
      /* object-fit: cover; */
    }

    .edit-cover-btn {
      width: 40px;
      height: 40px;
      position: absolute;
      right: 15px;
      bottom: 15px;
      background-color: rgba(255, 170, 50, 0.6);
      color: white;
      border: none;
      border-radius: 50%;
      padding: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .edit-cover-btn:hover {
      background-color: rgb(255, 151, 6);
    }

    .avatar-container {
      position: relative;
      margin-top: -150px;
      display: inline-block;
    }

    .avatar-img {
      width: 210px;
      height: 210px;
      /* object-fit: cover; */
      border-radius: 50%;
      border: 5px solid white;
      background-color: #f0f0f0;
    }

    .edit-avatar-btn {
      width: 40px;
      height: 40px;
      position: absolute;
      right: 0;
      bottom: 20px;
      background-color: rgba(255, 170, 50, 0.6);
      color: rgb(255, 255, 255);
      border: none;
      border-radius: 50%;
      padding: 8px;
      cursor: pointer !important;
      transition: background-color 0.3s ease;
    }

    .edit-avatar-btn:hover {
      background-color: rgb(255, 151, 6);
      cursor: pointer;
    }

    .profile-info {
      margin-top: 15px;
    }

    .username {
      font-weight: bold;
      margin-bottom: 3;
      margin-left: 20px;
    }

    .user-desc {
      color: #555;
      font-size: 16px;
    }
    .username-container {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
}

.edit-username-btn {
  /* background-color: rgb(255, 180, 5); */
  background-color: rgb(255, 238, 198);
  border: none;
  border-radius: 50%;
  padding: 8px;
  width: 35px;
  height: 35px;
  color: rgb(255, 180, 5);
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.edit-username-btn:hover {
  color: rgb(255, 126, 5);
}
  </style>
</head>
<body>
  <div class="container">
  <div class="profile-container">
    <div class="cover-photo">
      <img src="/images/mau-anh-bia-dep-cute-1.jpg" alt="Cover Photo" class="cover-img">
      <button class="edit-cover-btn" type="button" data-bs-toggle="modal" data-bs-target="#edit_coverModal">
        <i class="fas fa-camera"></i>
      </button>
    </div>
    <div class="avatar-container">
      <img src="/images/user-default.png" alt="Avatar" class="avatar-img">
      <button class="edit-avatar-btn" type="button" data-bs-toggle="modal" data-bs-target="#edit_avatarModal">
        <i class="fas fa-camera"></i>
      </button>
    </div>
    <div class="profile-info">
      <div class="username-container">
        <h2 class="username" style="font-size: 26px;">{{$user->full_name}}</h2>
        <button class="edit-username-btn" title="Chỉnh sửa tên" type="button" data-bs-toggle="modal" data-bs-target="#edit_infoModal">
          <i class="fas fa-pen"></i>
        </button>
      </div>
      <p class="user-desc">{{$user->bio}}</p>
    </div>
  </div>
  </div>
</body>
</html>
@endsection
@section('scripts')
@if ($errors->any())
    <script>
        window.onload = function () {
            var myModal = new bootstrap.Modal(document.getElementById('edit_infoModal'));
            myModal.show();
        }
    </script>
@endif
@endsection
@include('profile.edit_avatar')
@include('profile.edit_cover')
@include('profile.edit_info')