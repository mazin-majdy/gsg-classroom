@extends('layouts.master')
@section('title', 'Edit Topic' . ' ' . $topic->name)
@section('content')
    <div class="container">

        <h1>Edit Topic</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('topics.update', [$topic->id, 4]) }}" method="POST">
            @csrf
            @method('put')
            <div class="form-floating mb-3">
                <input type="text" class="form-control @error('name')is-invalid @enderror" name="name" id="name"
                    placeholder="Topic Name" value="{{ old('name', $topic->name) }}">
                <label for="name">Topic Name</label>
                @error('name')
                    <small class="invalid-feedback">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Update Topic</button>

        </form>
    </div>

@endsection
