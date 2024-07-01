<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.label.index.header') }}</x-slot>
    @if (Auth::check())
        <div class="mb-4">
            <a href="{{ route('labels.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('views.label.index.create') }}</a>
        </div>
    @endif
    <table class="w-full">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('models.label.id') }}</th>
                <th>{{ __('models.label.name') }}</th>
                <th>{{ __('models.label.description') }}</th>
                <th>{{ __('models.label.created_at') }}</th>
                @if (Auth::check())
                    <th>{{ __('views.label.index.actions') }}</th>
                @endif
            </tr>
            @foreach ($labels as $label)
                <tr class="border-b border-dashed text-left">
                    <td>{{ $label->id }}</td>
                    <td>{{ $label->name }}</td>
                    <td>{{ $label->description }}</td>
                    <td>{{ date('d.m.Y', strtotime($label->created_at)) }}</td>
                    @if (Auth::check())
                        <td>
                            <a href="{{ route('labels.destroy', $label) }}"
                                data-confirm="{{ __('views.label.index.areYouSure') }}" data-method="delete"
                                class="text-red-600 hover:text-red-900">{{ __('views.label.index.delete') }}</a>
                            <a href="{{ route('labels.edit', $label) }}"
                                class="text-blue-600 hover:text-blue-900">{{ __('views.label.index.update') }}</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </thead>
    </table>
</x-app-layout>
