@props(['disabled' => false, 'items' => [], 'value' => []])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
]) !!} multiple>
    @foreach ($items as $key => $title)
        <option value="{{ $key }}" @if (in_array($key, $value)) selected="selected" @endif>{{ $title }}</option>
    @endforeach
</select>
