<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.status.index.header') }}</x-slot>
    @if (Auth::check())
        <div class="mb-4">
            <a href="{{ route('task_statuses.create') }}"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('views.status.index.create') }}</a>
        </div>
    @endif
    <table class="w-full">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('models.status.id') }}</th>
                <th>{{ __('models.status.name') }}</th>
                <th>{{ __('models.status.created_at') }}</th>
                @if (Auth::check())
                    <th>{{ __('views.status.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
                <tr class="border-b border-dashed text-left">
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    <td>{{ $status->created_at }}</td>
                    @if (Auth::check())
                        <td>
                            <a href="{{ route('task_statuses.edit', $status) }}"
                                class="text-blue-600 hover:text-blue-900">{{ __('views.status.index.update') }}</a>
                            <a href="{{ route('task_statuses.destroy', $status) }}"
                                data-confirm="{{ __('views.status.index.areYouSure') }}" data-method="delete"
                                class="text-red-600 hover:text-red-900">{{ __('views.status.index.delete') }}</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
