// doi anh bia
document.addEventListener('DOMContentLoaded', function () {
    let cropper;
    const input = document.getElementById('coverInput');
    const image = document.getElementById('coverPreview');
    const chooseBtn = document.getElementById('chooseCoverBtn');

    chooseBtn.addEventListener('click', () => {
      input.click();
    });

    input.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (event) {
        image.src = event.target.result;
        image.style.display = 'block';

        if (cropper) {
          cropper.destroy();
        }

        cropper = new Cropper(image, {
          aspectRatio: 911 / 337,
          viewMode: 1,
          autoCropArea: 1
        });
      };
      reader.readAsDataURL(file);
    });

    document.getElementById('saveCroppedCover').addEventListener('click', function () {
      if (!cropper) return;

      const canvas = cropper.getCroppedCanvas({
        width: 911,
        height: 337,
      });

      canvas.toBlob(function (blob) {
        const formData = new FormData();
        formData.append('cover', blob, 'cover.jpg');

        axios.post('/profile/upload-cover', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
          .then(response => {
            alert('Tải lên thành công!');
            location.reload();
          })
          .catch(error => {
            console.error(error);
            alert('Có lỗi xảy ra khi tải lên.');
          });
      }, 'image/jpeg');
    });
});

// doi anh dai dien
document.addEventListener('DOMContentLoaded', function () {
    let cropper;
    const input = document.getElementById('avatarInput');
    const image = document.getElementById('avatarPreview');
    const chooseBtn = document.getElementById('chooseAvatarBtn');

    chooseBtn.addEventListener('click', () => {
      input.click();
    });

    input.addEventListener('change', function (e) {
      const file = e.target.files[0];
      if (!file) return;

      const reader = new FileReader();
      reader.onload = function (event) {
        image.src = event.target.result;
        image.style.display = 'block';

        if (cropper) {
          cropper.destroy();
        }

        cropper = new Cropper(image, {
          aspectRatio: 1,
          viewMode: 1,
          autoCropArea: 1
        });
      };
      reader.readAsDataURL(file);
    });

    document.getElementById('saveCroppedAvatar').addEventListener('click', function () {
      if (!cropper) return;

      const canvas = cropper.getCroppedCanvas({
        width: 300,
        height: 300,
      });

      canvas.toBlob(function (blob) {
        const formData = new FormData();
        formData.append('avatar', blob, 'avatar.jpg');

        axios.post('/profile/upload-avatar', formData, {
          headers: {
            'Content-Type': 'multipart/form-data'
          }
        })
          .then(response => {
            alert('Tải lên thành công!');
            location.reload();
          })
          .catch(error => {
            console.error(error);
            alert('Có lỗi xảy ra khi tải lên.');
          });
      }, 'image/jpeg');
    });
  });