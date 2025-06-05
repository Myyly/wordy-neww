<!-- Modal Xác nhận Xóa -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header custom-modal">
              <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body custom-modal-body">
              Bạn có chắc chắn muốn xóa flashcard này không?
          </div>
          <div class="modal-footer custom-modal">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <!-- Form Xóa -->
              <form id="deleteForm" method="POST" action="">
                  @csrf
                  <button type="submit" class="btn btn-danger">Xóa</button>
              </form>
          </div>
      </div>
  </div>
</div>