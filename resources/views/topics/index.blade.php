@extends('layouts.master')

@section('title', 'Topics')
@section('content')
<div class="container">

    <h1>Topics</h1>
    <a href="{{ route('topics.create', 37) }}" class="btn btn-primary px-3 my-2">Create <i class="fa-solid fa-plus"></i></a>
    <a href="{{ route('topics.trashed', 37) }}" class="btn btn-primary px-3 my-2">Trashed <i class="fa-solid fa-trash"></i></a>
    <div class="col my-5">

        @foreach ($topics as $topic)
            <div class=" mb-5 border-bottom py-2 d-flex justify-content-between">
                <h5 class="">{{ $topic->name }}</h5>
                <div class="btn-group">
                    <button type="button" class="btn" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a href="{{ route('topics.show', [$topic->id, 37]) }}" class="dropdown-item" type="button">Show</a></li>
                        <li><a href="{{ route('topics.edit', [$topic->id, 37]) }}" class="dropdown-item" type="button">Edit</a></li>
                        <li>
                            <form action="{{ route('topics.destroy', [$topic->id, 37]) }}" method="post">
                                @csrf
                                @method('delete')
                                <button class="dropdown-item">Delete</button>
                            </form>
                        </li>
                    </ul>
                </div>
                {{-- <a href="{{ route('topics.show', $topic->id) }}" class="btn btn-sm btn-primary">View</a>
                        <a href="{{ route('topics.edit', $topic->id) }}" class="btn btn-sm btn-dark">Edit</a>
                        <form action="{{ route('topics.destroy', $topic->id) }}" method="post">
                            @csrf
                            @method('delete')
                            <button class="btn btn-danger btn-sm">Delete</button>
                        </form> --}}
            </div>
        @endforeach
    </div>

</div>
@endsection
