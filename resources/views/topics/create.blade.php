@extends('layouts.master')
@section('title', 'Create Topic')
@section('content')
<div class="container">

    <h1>Create Topic</h1>

    <form action="{{ route('topics.store') }}" method="POST">
        @csrf
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Topic Name">
            <label for="name">Topic Name</label>
        </div>

        <button type="submit" class="btn btn-primary">Create Topic</button>

    </form>
</div>

@
@endsection
