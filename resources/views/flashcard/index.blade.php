@extends('layouts.app')
@section('content')
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
        <div class="tool-search-wrapper">
        <div class="tool-bar">
            <button type="button" class="btn btn-secondary" 
            data-bs-toggle="modal" 
            data-bs-target="#addModal"
            data-list_id="{{ $list_word->id}}"
            >
            Add Word
            </button> 
            <button type="button" class="btn btn-secondary width-110"
                    data-bs-toggle="modal" 
                    data-bs-target="#edit_listModal"
                    data-list_id="{{ $list_word->id}}"
                    data-word_title="{{ $list_word->title }}"
                    data-word_description="{{ $list_word->description }}"
                    data-edit_list-url="{{ route('edit_list', $list_word->id) }}"
                    >
                    Manage List
            </button> 
        <form method="get" action="{{route('list-word')}}">      
            <button type="submit">
                Back to List
            </button> 
        </form> 
            <button type="button" class="btn btn-dark" id="checkAllBtn">Toggle All Definitions</button>
        </div>
        <form action="{{route('search')}}" method="get">
            @csrf
        <div class="search-bar">
            <h4 class="title-search ">Search</h4>
            <input type="hidden" value="{{ $list_word->id}}" name="list_id">
            <input type="text" class="form-control" id="search" placeholder="Enter word..." name="search" value="{{ request('search') }}">
            <button type="submit" class="btn btn-primary">Search</button>
        </div>
    </form>
    </div>
    </div>
    {{-- @include('flashcard.list_flashcard') --}}
    <div class="list">
    <div class="main-container">
        <h2 class="primay-color">{{ $list_word->title}} </h2>
        <table class="table table-bordered">
          <thead class="text-center align-middle">
            <tr>
              <th>No.</th>
              <th>Word</th>
              <th>Word Type</th>
              <th>Pronunciation</th>
              <th class="definition-header">Definition</th>
              <th>Example</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($flashcards as $flashcard)
            <tr>
                <td class="text-center align-middle">{{ $loop->iteration }}</td>
                <td>
                    {{ $flashcard->word }}
                    <button class="icon-button" onclick="speak('{{ addslashes($flashcard->word) }}')">
                        <i class="fas fa-volume-up"></i>
                    </button>
                </td>
                <td class="text-center align-middle">{{ $flashcard->word_type }}</td>
                <td>{{ $flashcard->pronunciation }}</td>
                <td class="definition-col">
                    <span class="definition-content">{{ $flashcard->definition }}</span>
                </td>
                <td class="pre-line">{{ $flashcard->example }}</td>
                <td class="col-md-2 text-center align-middle">
                    <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="icon-button" data-bs-toggle="modal" 
                        data-bs-target="#deleteModal"
                        data-id="{{ $flashcard->id }}"
                        data-delete-url="{{ route('delete', $flashcard->id) }}"
                        >
                        <i class="fa-solid fa-trash"></i>
                    </button>
                    {{-- <form action="{{ route('detail', ['id' => $flashcard->id]) }}" method="GET">
                        <button type="submit" class="btn btn-info action">Detail</button>
                    </form> --}}
                    <button type="button" class="icon-button" 
                    data-bs-toggle="modal" 
                    data-bs-target="#editModal"
                    data-id="{{ $flashcard->id}}"
                    data-word = "{{ $flashcard->word}}"
                    data-definition ="{{ $flashcard->definition}}"
                    data-word_type="{{ $flashcard->word_type}}"
                    data-pronunciaton="{{ $flashcard->pronunciation}}"
                    data-example="{{ $flashcard->example}}"
                    data-edit-url="{{ route('edit', $flashcard->id) }}"
                    >
                    <i class="fa-solid fa-pen-to-square"></i>
                    </button> 
                    <button type="button" class="icon-button toggle-definition-btn">
                        <i class="fa-solid fa-eye"></i>
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
{{-- <script src="{{ asset('js/account.js') }}"></script> --}}
<script src="{{ asset('js/flashcard.js') }}"></script>
<script src="{{ asset('js/general.js') }}"></script>

@endsection
