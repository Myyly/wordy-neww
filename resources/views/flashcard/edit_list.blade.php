<form id="edit_listForm" method="POST" action="">
    @csrf
  <div class="modal" id="edit_listModal">
      <div class="modal-dialog">
        <div class="modal-content">
          <!-- Modal Header -->
          <div class="modal-header custom-modal">
            <h4 class="modal-title">Chỉnh sửa list từ</h4>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>

          <!-- Modal body -->
          <div class="modal-body custom-modal-body">
          <div class="mb10"> 
            <h6>Tiêu đề:<label class="cl-red">*</label></h6>
            <input type="text" class="form-control" name="title" id="title">
          </div>
            <h6> Mô tả:<label class="cl-red">*</label></h6>
            <textarea class="form-control" rows="5" name="description"id="description"></textarea>
          </div>
          <div class="modal-footer custom-modal">
            <button type="button" class="btn btn-danger" 
            data-bs-toggle="modal" 
            data-bs-target="#delete_listModal">
            Delete list
          </button>
            <button type="submit" class="btn btn-primary width110 btn-modal">Save</button>
          </div>
        </div>
      </div>
    </div>
  </form>
<!-- Modal Xác nhận Xóa -->
<div class="modal fade" id="delete_listModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header custom-modal">
              <h5 class="modal-title" id="deleteModalLabel">Xác nhận xóa</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body custom-modal-body">
              Bạn có chắc chắn muốn xóa danh sách từ này không? 
          </div>
          <div class="modal-footer custom-modal">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
              <!-- Form Xóa -->
              <form method="POST" action="{{route('delete_list')}}">
                  @csrf
                  <input type="hidden" id="list_id" name="list_id">
                  <button type="submit" class="btn btn-danger">Xóa</button>
              </form>
          </div>
      </div>
  </div>
</div>