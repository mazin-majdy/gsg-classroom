@extends('layouts.master')
@section('title', 'Edit Classroom ' . $classroom->name)
@section('content')
    @push('styles')
        <style>
            .cover_image {
                width: 200px;
                height: 100px;
                object-fit: cover;
            }
        </style>
    @endpush
    <div class="container">

        <h1>Update Classroom</h1>

        <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Form Method Sppofing --}}
            {{-- <input type="hidden" name="_method" value="put"> --}}
            {{-- {{ method_field('put') }} --}}
            @method('put')
            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->name }}" name="name" id="name"
                    placeholder="Class Name">
                <label for="name">Class Name</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->section }}" name="section" id="section"
                    placeholder="Section">
                <label for="section">Section</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->subject }}" name="subject" id="subject"
                    placeholder="Subject">
                <label for="subject">Subject</label>
            </div>

            <div class="form-floating mb-3">
                <input type="text" class="form-control" value="{{ $classroom->room }}" name="room" id="room"
                    placeholder="Room">
                <label for="room">Room</label>
            </div>

            <img src="{{ Storage::disk('public')->url($classroom->cover_image_path) }}" class="cover_image" alt="...">
            {{-- <img src="{{asset('storage/' . $classroom->cover_image_path) }}" class="cover_image" alt="..."> --}}
            <div class="form-floating mb-3">
                <input type="file" class="form-control" name="cover_image" id="cover_image" placeholder="Room">
                <label for="cover_image">Cover image</label>
            </div>

            <button type="submit" class="btn btn-primary">Update Room</button>

        </form>
    </div>

@endsection
