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
{{-- <script src="{{ asset('js/account.js') }}"></script> --}}
<script src="{{ asset('js/flashcard.js') }}"></script>
@endsection
