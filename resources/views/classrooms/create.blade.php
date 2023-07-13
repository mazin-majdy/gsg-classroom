@extends('layouts.master')
@section('title', 'Create Classroom')
@section('content')
<div class="container">

    <h1>Create Classroom</h1>

    <form action="{{ route('classrooms.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- {{ csrf_filed() }} --}}
        {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="name" id="name" placeholder="Class Name">
            <label for="name">Class Name</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="section" id="section" placeholder="Section">
            <label for="section">Section</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="subject" id="subject" placeholder="Subject">
            <label for="subject">Subject</label>
        </div>

        <div class="form-floating mb-3">
            <input type="text" class="form-control" name="room" id="room" placeholder="Room">
            <label for="room">Room</label>
        </div>

        <div class="form-floating mb-3">
            <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder="Room">
            <label for="cover_image">Cover image</label>
        </div>

        <button type="submit" class="btn btn-primary">Create Room</button>

    </form>
</div>

@endsection
