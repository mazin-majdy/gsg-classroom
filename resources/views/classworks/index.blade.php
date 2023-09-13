<x-main-layout :title="$classroom->name">
    <div class="container">
        <h1>{{ $classroom->name }} - (#{{ $classroom->id }})</h1>
        <x-alert :name="$success" />
        <h3>Classwork </h3>
        @can('create', ['App\Models\Classwork', $classroom])
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    + Create
                </button>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'assignment']) }}">Assignment</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'material']) }}">Material</a>
                    </li>
                    <li><a class="dropdown-item"
                            href="{{ route('classrooms.classworks.create', [$classroom->id, 'type' => 'question']) }}">Question</a>
                    </li>
                </ul>
            </div>
        @endcan

        <hr>

        <form action="{{ URL::current() }}" method="get" class="row row-cols-lg-auto g-3 align-items-center">
            <div class="col-12">
                <input type="text" name="search" class="form-control" placeholder="Search...">
            </div>
            <div class="col-12">
                <button class="btn btn-primary" type="submit">Find</button>
            </div>
        </form>

        @forelse ($classworks as $group)

            <h3>{{ $group->first()->topic?->name }}</h3>
            <div class="accordion accordion-flush mt-2" id="accordionFlushExample">
                @foreach ($group as $classwork)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapse{{ $classwork->id }}" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                {{ $classwork->title }}
                            </button>
                        </h2>
                        <div id="flush-collapse{{ $classwork->id }}" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        {!! $classwork->description !!}
                                    </div>
                                    <div class="col-md-6 row">
                                        <div class="col-md-4">
                                            <div class="fs-3"> {{ $classwork->assigned_count }}</div>
                                            <div class="text-muted">{{ __('Assigned') }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fs-3"> {{ $classwork->turnedin_count }}</div>
                                            <div class="text-muted">{{ __('Turned-in') }}</div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="fs-3"> {{ $classwork->graded_count }}</div>
                                            <div class="text-muted">{{ __('Graded') }}</div>
                                        </div>
                                    </div>

                                </div>
                                <div>
                                    <a class="btn btn-sm btn-outline-dark"
                                        href="{{ route('classrooms.classworks.edit', [$classwork->classroom_id, $classwork->id]) }}">Edit</a>
                                    <a class="btn btn-sm btn-outline-success"
                                        href="{{ route('classrooms.classworks.show', [$classwork->classroom_id, $classwork->id]) }}">View</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @empty
            <p class="text-center fs-4">No classworks found.</p>
        @endforelse

        {{-- بحافظ ع الكويري الي باليوارال --}}
        {{-- {{ $classworks->withQueryString()->links('vendor.pagination.bootstrap-5') }} --}}
        {{-- {{ $classworks->withQueryString()->appends(['v' => 1])->links() }} --}}

        {{-- {{ $classworks->withQueryString()->links() }} --}}

    </div>

    @push('scripts')
        <script>
            classroomId = "{{ $classwork->classroom_id }}";
        </script>
    @endpush
</x-main-layout>
