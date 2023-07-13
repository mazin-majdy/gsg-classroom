@extends('layouts.master')

@section('title', 'Classrooms')
@section('content')
    <div class="container">

        @if ($success)
            <div class="alert alert-success">{{ $success }}</div>
        @endif

        <h1>Classrooms</h1>
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary px-3 my-2">Create <i class="fa-solid fa-plus"></i></a>

        <div class="row">

            @foreach ($classrooms as $classroom)
                <div class="col-md-3">
                    <div class="card">
                        {{-- php artisan storage:link --}}
                        <img src="{{asset('storage/' . $classroom->cover_image_path) }}" class="card-img-top" alt="...">
                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
                            <a href="{{ route('classrooms.show', $classroom->id) }}" class="btn btn-sm btn-primary">View</a>
                            <a href="{{ route('classrooms.edit', $classroom->id) }}" class="btn btn-sm btn-dark">Edit</a>
                            <form class="d-inline" action="{{ route('classrooms.destroy', $classroom->id) }}"
                                method="post">
                                @csrf
                                @method('delete')
                                <button class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection

{{-- @push('scripts')
<script>alert(1)</script>
@endpush --}}
