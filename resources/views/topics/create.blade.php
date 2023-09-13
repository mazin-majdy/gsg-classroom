@extends('layouts.master')
@section('title', 'Create Topic')
@section('content')
    <div class="container">

        <h1>Create Topic</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('topics.store', 37) }}" method="POST">
            @csrf
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" id="name"
                    placeholder="Topic Name">
                <label for="name">Topic Name</label>
                @error('name')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Create Topic</button>

        </form>
    </div>

@endsection
