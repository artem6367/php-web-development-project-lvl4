@props(['disabled' => false, 'items' => [], 'value' => null, 'defaultTitle' => ''])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge([
    'class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm',
]) !!}>
    <option value @if ($value === null) selected="selected" @endif>{{ $defaultTitle }}</option>
    @foreach ($items as $key => $title)
        <option value="{{ $key }}" @if ($key == $value) selected="selected" @endif>{{ $title }}</option>
    @endforeach
</select>
