@extends('layouts.app')
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="container">
        <div class="action-bar">
            <div class="tool-bar">
                <form method ="get" action="{{route('list-word')}}">
                <button type="submit" class="btn-add width-200">
                   List word
                </button>
                </form>
            </div>
            <form method="GET" action="{{route('search_all')}}">
                <div class="search-bar">
                    <h4 class="title-search">Search</h4>
                    <input type="text" class="form-control" id="search" placeholder="Enter word..." name="search" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>
        <div class="main-container mt-4">
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
                            <td>{{ $flashcard->pronunciation }}</td>
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
    @vite(['resources/js/gerneral.js'])

    @section('scripts')

    @endsection