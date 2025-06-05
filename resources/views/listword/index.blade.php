@extends('layouts.app')
@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-message">
            {{ session('success') }}
        </div>
    @endif
<?php  
$user = auth()->user();
?>
    <div class="container-fluid">
        <div class="action-bar">
            <div class="tool-bar">
                <form method ="get" action="{{route('practice_index')}}">
                <button type="submit" class="btn-add width-200">
                    Practice
                </button>
                </form>
                {{-- <form method ="get" action="{{route('grammar_index')}}">
                <button type="submit" class="btn-add width-200">
                    Grammar
                </button>
                </form> --}}
            </div>
            <form method="GET" action="{{route('search_all')}}">
                <div class="search-bar">
                    <h4 class="title-search">Search</h4>
                    <input type="text" class="form-control" id="search" placeholder="Enter word..." name="search" value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>
        </div>

        <div class="main-container mt-4 ">
            <div class="container mt-4">
                <h4 class="mb-3">List word:</h4>
                <div class="row row-cols-2 row-cols-md-4 row-cols-lg-5 g-3">
                    <div class="col">
                        <div
                            class="card text-center border-dashed shadow-sm h-100 d-flex align-items-center justify-content-center">
                            <div class="p-4">
                                <button type="button" data-bs-toggle="modal" data-bs-target="#add_listModal"
                                    style="background-color: none;">
                                    <i class="fa fa-plus fa-2x"></i>
                                    <p class="mt-2">Create list</p>
                                </button>
                            </div>
                        </div>
                    </div>
                    @foreach ($list_words as $word)
                        <div class="col">
                            <a href="{{ route('index', ['list_id' => $word->id]) }}" class="text-decoration-none">
                                <div class="card shadow-sm h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $word->title }}</h5>
                                        <p class="text-muted">
                                            <i class="fa fa-book"></i> {{ $word->flashcards_count }} từ
                                        </p>
                                        <p class="small text-secondary">{{ $word->description }}</p>
                                    </div>
                                    <div class="card-footer bg-white d-flex align-items-center">
                                        <img src="{{ asset($user->avatar_img) }}" class="avatar" alt="avatar">
                                        <span class="small">{{$user->full_name}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3" style="margin-top: -80px !important">
                {{ $list_words->links() }}
            </div>
        </div>
    </div>
@endsection
    @include('listword.add')
    @section('scripts')
    <script src="{{ asset('js/account.js') }}"></script>
    <script src="{{ asset('js/general.js') }}"></script>
    @endsection