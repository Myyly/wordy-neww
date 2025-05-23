<div class="list">
    <div class="main-container">
        <h2>FLASHCARD</h2>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No.</th>
              <th>Word</th>
              <th class="definition-header">Definition</th>
              <th>Word Type</th>
              <th>Pronunciation</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($flashcards as $flashcard)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $flashcard->word }}</td>
                <td class="definition-col">{{ $flashcard->definition }}</td>
                <td>{{ $flashcard->word_type }}</td>
                <td>
                    {{ $flashcard->pronunciation }}
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="speak('{{ $flashcard->pronunciation }}')">🔊</button>
                </td>
                <td class="col-md-2">
                    <div class="d-flex justify-content-center gap-2">
                    <!-- Nút mở modal xác nhận xóa -->
                    <button type="button" class="btn btn-danger action" data-bs-toggle="modal" 
                        data-bs-target="#deleteModal"
                        data-id="{{ $flashcard->id }}">
                        Delete
                    </button>
                    <button type="button" class="btn btn-secondary action" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal"
                    data-id="{{ $flashcard->id}}"
                    data-word = "{{ $flashcard->word}}"
                    data-definition ="{{ $flashcard->definition}}"
                    data-word_type="{{ $flashcard->word_type}}"
                    data-pronunciaton="{{ $flashcard->pronunciation}}"
                    >
                        Edit
                    </button>
                    <form>
                    <button type="button" class="btn btn-danger action">
                   practice
                </button>
            </form> 
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
        </table>
        
    </div>
    <div class="mt-3">
        {{ $flashcards->links() }}
    </div>
</div>
