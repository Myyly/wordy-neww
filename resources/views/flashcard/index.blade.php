@extends('layouts.app')
@section('content')
    {{-- <form method="POST" action={{route('add')}}> --}}
      
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
          {{ session('success') }}
      </div>
  @endif
  
<div class="container">
@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif
    <div class="action-bar">
        <div class="tool-bar">
            <button type="button" class="btn btn-secondary" 
            data-bs-toggle="modal" 
            data-bs-target="#addModal"
            data-list_id="{{ $list_word->id}}"
            >
                Add new
            </button> 
            <button type="button" class="btn btn-secondary width-110"
                    data-bs-toggle="modal" 
                    data-bs-target="#edit_listModal"
                    data-list_id="{{ $list_word->id}}"
                    data-word_title="{{ $list_word->title }}"
                    data-word_description="{{ $list_word->description }}"
                    >
                Edit List
            </button> 
        <form method="get" action="{{route('list-word')}}">      
            <button type="submit">
                Back
            </button> 
        </form> 
            <button type="button" class="btn btn-dark" id="checkAllBtn">Check All</button>
        </div>
        <form action="{{route('search')}}" method="get">
            @csrf
        <div class="search-bar">
            <h4 class="title-search">Search</h4>
            <input type="hidden" value="{{ $list_word->id}}" name="list_id">
            <input type="text" class="form-control" id="search" placeholder="Enter word..." name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    </div>
    {{-- @include('flashcard.list_flashcard') --}}
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
                <td>
                    {{ $flashcard->word }}
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="speak('{{ addslashes($flashcard->word) }}')">🔊</button>
                </td>
                <td class="definition-col">
                    {{ $flashcard->definition }}
                </td>
                <td>{{ $flashcard->word_type }}</td>
                <td>{{ $flashcard->pronunciation }}</td>
                {{-- <td>
                    {{ $flashcard->pronunciation }}
                    <button class="btn btn-sm btn-outline-primary ms-2" onclick="speak('{{ $flashcard->pronunciation }}')">🔊</button>
                </td> --}}
                <td class="col-md-2">
                    <div class="d-flex justify-content-center gap-2">
                    <!-- Nút mở modal xác nhận xóa -->
                    <button type="button" class="btn btn-danger action" data-bs-toggle="modal" 
                        data-bs-target="#deleteModal"
                        data-id="{{ $flashcard->id }}">
                        Delete
                    </button>
                    <form action="{{ route('detail', ['id' => $flashcard->id]) }}" method="GET">
                        <button type="submit" class="btn btn-info action">Detail</button>
                    </form>
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
</div>
@endsection
@include('flashcard.add')
@include('flashcard.edit')
@include('flashcard.delete')
@include('flashcard.edit_list')

@section('scripts')
<script src="{{ asset('js/account.js') }}"></script>

<script>
    $("#checkAllBtn").click(function () {
    $(".definition-col").toggle(); 
    $(".definition-header").toggle();
});
$(document).ready(function () {
    $('#deleteModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let deleteUrl = "{{ route('delete', ':id') }}".replace(':id', id);
        $('#deleteForm').attr('action', deleteUrl);
    });
});
$(document).ready(function () {
    $('#addModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('list_id');
        $('#id_list').val(id);
    });
});
$(document).ready(function () {
    $('#edit_listModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('list_id');
        let title = button.data('word_title');
        let description = button.data('word_description');
         $('#title').val(title);
         $('#description').val(description);
         $('#list_id').val(id);
       let edit_listUrl = "{{ route('edit_list', ':id') }}".replace(':id', id);
        $('#edit_listForm').attr('action', edit_listUrl);
    });
});
$(document).ready(function () {
    $('#editModal').on('show.bs.modal', function (event) {
        let button = $(event.relatedTarget);
        let id = button.data('id');
        let word = button.data('word');
        let definition = button.data('definition');
        let word_type = button.data('word_type');
        let pronunciaton = button.data('pronunciaton');

        let editUrl = "{{ route('edit', ':id') }}".replace(':id', id);
        $('#editForm').attr('action', editUrl);
        $('#word').val(word);
        $('#definition').val(definition);
        $('#word_type').val(word_type);
        $('#pronunciaton').val(pronunciaton);
    });
});
function speak(text) {
    if ('speechSynthesis' in window) {
        speechSynthesis.cancel();

        const utterance = new SpeechSynthesisUtterance(text);
        utterance.lang = 'en-US'; // Ngôn ngữ

        // Lấy danh sách giọng
        let voices = speechSynthesis.getVoices();

        // Nếu chưa có giọng (vì voices load bất đồng bộ), lắng nghe sự kiện voiceschanged
        if (voices.length === 0) {
            speechSynthesis.addEventListener('voiceschanged', () => {
                voices = speechSynthesis.getVoices();
                setVoiceAndSpeak(voices, utterance);
            });
        } else {
            setVoiceAndSpeak(voices, utterance);
        }

        // Hàm chọn giọng và phát âm
        function setVoiceAndSpeak(voicesList, utter) {
            // Ví dụ chọn giọng tiếng Anh nữ có tên chứa 'Google' (thường có trên Chrome)
            const selectedVoice = voicesList.find(v => v.lang === 'en-US' && v.name.includes('Google'));

            if (selectedVoice) {
                utter.voice = selectedVoice;
            } else {
                // Nếu không tìm được giọng Google, chọn giọng đầu tiên cùng ngôn ngữ
                utter.voice = voicesList.find(v => v.lang === 'en-US') || null;
            }

            utter.rate = 0.7;  // tốc độ đọc
            utter.pitch = 1.0; // cao độ
            utter.volume = 0.6;  // âm lượng

            speechSynthesis.speak(utter);
        }
    } else {
        alert("Trình duyệt không hỗ trợ phát âm!");
    }
}
  </script>
@endsection
