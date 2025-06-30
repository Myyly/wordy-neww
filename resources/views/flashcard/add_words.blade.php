<div class="modal fade" id="add_wordsModal" tabindex="-1" aria-labelledby="addWordsModalLabel" aria-hidden="true">
    <form method="post" action="{{route('adds')}}">
        @csrf
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addWordsModalLabel">Create flashcards</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    <input type="hidden" class="form-control" name="id_list_words" id="id_list_words">
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Word <span class="required">*</span></th>
                                <th>Pronunciation</th>
                                <th>Definition <span class="required">*</span></th>
                                <th>Word Type</th>
                                <th>Example 1</th>
                                <th>Example 2</th>
                            </tr>
                        </thead>
                        @php
                            $oldWords = old('word');
                            $numRows = $oldWords ? count($oldWords) : 3;
                        @endphp
                        <tbody>
                            @for ($i = 0; $i < $numRows; $i++)
                                <tr>
                                    <td>{{ $i + 1 }}</td>
                                    <td><input type="text" class="form-control" name="word[]"
                                            value="{{ old('word')[$i] ?? '' }}"></td>
                                    <td><input type="text" class="form-control" name="pronunciation[]"
                                            value="{{ old('pronunciation')[$i] ?? '' }}"></td>
                                    <td><input type="text" class="form-control" name="definition[]"
                                            value="{{ old('definition')[$i] ?? '' }}"></td>
                                    <td><input type="text" class="form-control" name="word_type[]"
                                            value="{{ old('word_type')[$i] ?? '' }}"></td>
                                    <td><input type="text" class="form-control" name="example1[]"
                                            value="{{ old('example1')[$i] ?? '' }}"></td>
                                    <td><input type="text" class="form-control" name="example2[]"
                                            value="{{ old('example2')[$i] ?? '' }}"></td>
                                </tr>
                            @endfor
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer flex-column justify-content-center align-items-center">
                    @if(session('modal_error'))
                        <div class="text-danger fw-bold text-center mb-2">
                            {!! session('modal_error') !!}
                        </div>
                    @endif
                    <div class="d-flex justify-content-center gap-2">
                        <button type="button" class="btn btn-success font-weight-bold" id="addRowBtn">+ Thêm
                            dòng</button>
                        <button type="submit" class="btn btn-modal">Lưu</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@php
    $oldWords = old('word');
    $numRows = $oldWords ? count($oldWords) : 3;
@endphp
<script>
    let rowIndex = {{ $numRows + 1 }};
    document.getElementById('addRowBtn').addEventListener('click', function () {
        const tbody = document.querySelector('#add_wordsModal table tbody');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
        <td>${rowIndex}</td>
        <td><input type="text" class="form-control" name="word[]"></td>
        <td><input type="text" class="form-control" name="pronunciation[]"></td>
        <td><input type="text" class="form-control" name="definition[]"></td>
        <td><input type="text" class="form-control" name="word_type[]"></td>
        <td><input type="text" class="form-control" name="example1[]"></td>
        <td><input type="text" class="form-control" name="example2[]"></td>
        `;
        tbody.appendChild(newRow);
        rowIndex++;
    });
</script>