<div class="modal" id="edit_avatarModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Chỉnh sửa ảnh đại diện</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <button type="button" class="btn btn-outline-primary mb-3" id="chooseAvatarBtn">
          <i class="fa fa-image me-1"></i> Chọn ảnh
        </button>
        <input type="file" id="avatarInput" accept="image/*" style="display: none;" />
        <div style="max-height: 400px;">
          <img id="avatarPreview" style="max-width: 100%; display: none;" />
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" id="saveCroppedAvatar" class="btn btn-primary">Lưu ảnh</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
      </div>
    </div>
  </div>
</div>
<script>
  
</script>