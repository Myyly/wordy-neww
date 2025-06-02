<div class="modal" id="edit_coverModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Chỉnh sửa ảnh bìa</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <!-- Nút chọn ảnh -->
        <button type="button" class="btn btn-outline-primary mb-3" id="chooseCoverBtn">
          <i class="fa fa-image me-1"></i> Chọn ảnh
        </button>

        <!-- Input file ẩn -->
        <input type="file" id="coverInput" accept="image/*" style="display: none;" />

        <!-- Khu vực preview -->
        <div style="max-height: 300px;">
          <img id="coverPreview" style="max-width: 100%; display: none;" />
        </div>
      </div>

      <div class="modal-footer">
        <button type="button" id="saveCroppedCover" class="btn btn-primary">Lưu ảnh</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
      </div>

    </div>
  </div>
</div>
<script>

</script>