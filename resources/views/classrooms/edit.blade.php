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

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('classrooms.update', $classroom->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            {{-- Form Method Sppofing --}}
            {{-- <input type="hidden" name="_method" value="put"> --}}
            {{-- {{ method_field('put') }} --}}
            @method('put')

            @include('classrooms._form', [
                'button_label' => 'Update Classroom'
            ])
        </form>
    </div>

@endsection
