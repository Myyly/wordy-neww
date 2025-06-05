<!-- The Modal -->
<form method="POST" action="{{ route('create') }}">
    @csrf
<div class="modal" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header custom-modal">
        <h4 class="modal-title primay-color">Add Flascard</h4>
        <input type="hidden" class="form-control" name="id_list" id="id_list">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body custom-modal-body" >
        <div class="mb-3">
          <label for="word" class="form-label">Word</label>
          <input type="text" class="form-control" name="word_add">
        </div>
        <div class="mb-3">
          <label for="definition" class="form-label">Definition</label>
          <input type="text" class="form-control" name="definition" >
        </div>
        <div class="mb-3">
          <label for="word_type" class="form-label">Word Type</label>
          <input type="text" class="form-control" name="word_type" >
        </div>
        <div class="mb-3">
          <label for="pronunciaton" class="form-label">Pronunciation</label>
          <input type="text" class="form-control" name="pronunciaton" >
        </div>
        <div class="mb-3">
          <label for="example" class="form-label">Example (mỗi dòng 1 câu, tối đa 10)</label>
          <textarea class="form-control" name="example" id="example" rows="5" placeholder="Nhập ví dụ, mỗi dòng 1 câu..."></textarea>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer custom-modal">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success btn-modal">Save</button>
      </div>
    </div>
  </div>
</div>
</form>