<!-- The Modal -->
<form method="POST" action="{{ route('create') }}">
    @csrf
<div class="modal" id="addModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Add Flascard</h4>
        <input type="hidden" class="form-control" name="id_list" id="id_list">
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <!-- Modal body -->
      <div class="modal-body">
        <div class="container mt-3">
          <div class="input-group mb-3">
            <span class="input-group-text">Word</span>
            <input type="text" class="form-control" name="word">
          </div>
          <div class="input-group mb-3">
           <span class="input-group-text">Word type</span>
            <select class="form-select" name="word_type">
              <option>none</option>
              <option>a</option>
              <option>adv</option>
              <option>v</option>
              <option>n</option>
              
            </select>
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Definition</span>
            <input type="text" class="form-control" name="definition">
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text">Pronunciation</span>
            <input type="text" class="form-control" name="pronunciation">
          </div>
          <div class="mb-3">
            <label for="example" class="form-label">Ví dụ (mỗi dòng 1 câu, tối đa 10)</label>
            <textarea class="form-control" name="example" rows="5" placeholder="Nhập ví dụ, mỗi dòng 1 câu..."></textarea>
          </div>
        </div>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success">Save</button>
      </div>
    </div>
  </div>
</div>
</form>