<form action={{route('add')}} method="POST">
  @csrf
<div class="modal" id="add_listModal">
    <div class="modal-dialog">
      <div class="modal-content">
  
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Taọ list từ</h4>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
  
        <!-- Modal body -->
        <div class="modal-body">
        <div class="mb10"> 
          <h6>Tiêu đề:<label class="cl-red">*</label></h6>
          <input type="text" class="form-control" name="title">
        </div>
          <h6> Mô tả:<label class="cl-red">*</label></h6>
          <textarea class="form-control" rows="5" id="comment" name="description"></textarea>
        </div>
  
        <!-- Modal footer -->
        <div class="modal-footer">
          <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary width110">Save</button>
        </div>
  
      </div>
    </div>
  </div>
</form>