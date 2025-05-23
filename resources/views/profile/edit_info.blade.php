<div class="modal fade" id="edit_infoModal" tabindex="-1" aria-labelledby="edit_infoModalLabel" aria-hidden="true">
    <form method="POST" action="{{route('edit_infor')}}">
        @csrf
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editInfoModalLabel">Chỉnh sửa thông tin cá nhân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="fullName" class="form-label">Tên</label>
                        <input type="text" class="form-control" id="fullName" name="fullName"
                            placeholder="Nhập tên của bạn" value="{{ old('fullName') ?: $user->full_name }}">
                        @error('fullName')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="bio" class="form-label">Tiểu sử</label>
                        <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Giới thiệu bản thân">{{ old('bio', $user->bio) }}
                        </textarea>
                        @error('bio')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>

            </div>
        </div>
    </form>
</div>