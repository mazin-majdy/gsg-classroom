<x-main-layout :title="__('Classrooms')">

    <div class="container">

        {{-- alert component --}}
        {{-- <x-alert :success='$success' /> --}}
        {{-- @if ($success)
            <div class="alert alert-success">{{ $success }}</div>
            @endif --}}



        <h1>{{ __('Classrooms') }}</h1>
        <a href="{{ route('classrooms.create') }}" class="btn btn-primary px-3 my-2">Create <i
                class="fa-solid fa-plus"></i></a>

        <div id="classrooms"></div>
        <div class="row">

            @foreach ($classrooms as $classroom)
                <div class="col-md-3 mb-2">
                    <div class="card">
                        <img src="{{ $classroom->cover_image_url }}" class="card-img-top" alt="...">
                        {{-- php artisan storage:link --}}
                        <div class="card-body">
                            <h5 class="card-title">{{ $classroom->name }}</h5>
                            <p class="card-text">{{ $classroom->section }} - {{ $classroom->room }}</p>
                            <div class="d-flex justify-content-end">

                                <a href="{{ $classroom->url }}" class="btn btn-sm btn-primary"><i
                                        class="fa-solid fa-eye"></i></a>

                                <a href="{{ route('classrooms.edit', $classroom->id) }}"
                                    class="btn btn-sm btn-dark mx-2"><i class="fa-regular fa-pen-to-square"></i></a>

                                <form class="d-inline" action="{{ route('classrooms.destroy', $classroom->id) }}"
                                    method="post">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash-can"></i></button>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
    @push('scripts')
        <script>
            fetch('/api/v1/classrooms')
                .then(res => res.json())
                .then(json => {
                    let ul = document.getElementById('classrooms');
                    for (let i in json.data) {
                        ul.innerHTML += `<li>${json.data[i].name}</li>`
                    }
                })
        </script>
    @endpush
</x-main-layout>
