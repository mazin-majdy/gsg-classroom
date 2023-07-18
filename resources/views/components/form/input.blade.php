@props([
    'value' => '', 'name',
])
<input
    value="{{ old($name, $value) }}"
    {{-- class="form-control @error('name')is-invalid @enderror" --}}
    name="{{ $name }}"
    id="{{ $id ?? $name }}"
    {{ $attributes->merge([
        'type' => 'text',
    ])->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
>
