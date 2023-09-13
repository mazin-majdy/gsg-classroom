@php
    $name = str_replace('[', '.', $name);
    $name = str_replace(']', '', $name);
@endphp

@error($name)
    <small class="invalid-feedback">{{ $message }}</small>
@enderror
