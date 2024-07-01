<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.task.index.header') }}</x-slot>
    <div class="w-full flex items-center">
        <div>
            <form method="GET" action="{{ route('tasks.index') }}">
                <div class="flex">
                    <x-select id="filter[status_id]" name="filter[status_id]" :items=$statuses :defaultTitle="__('models.task.status')" :value="$filter['status_id']" />
                    <x-select id="filter[created_by_id]" name="filter[created_by_id]" :items=$users :defaultTitle="__('models.task.author')" :value="$filter['created_by_id']" />
                    <x-select id="filter[assigned_to_id]" name="filter[assigned_to_id]" :items=$users :defaultTitle="__('models.task.executor')" :value="$filter['assigned_to_id']" />
                    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2"
                        type="submit">{{ __('views.task.index.toFilter') }}</button>
                </div>
            </form>
        </div>
        @if (Auth::check())
            <div class="ml-auto">
                <a href="{{ route('tasks.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('views.task.index.create') }}</a>
            </div>
        @endif
    </div>
    <table class="w-full">
        <thead class="border-b-2 border-solid border-black text-left">
            <tr>
                <th>{{ __('models.task.id') }}</th>
                <th>{{ __('models.task.status') }}</th>
                <th>{{ __('models.task.name') }}</th>
                <th>{{ __('models.task.author') }}</th>
                <th>{{ __('models.task.executor') }}</th>
                <th>{{ __('models.task.created_at') }}</th>
                @if (Auth::check())
                    <th>{{ __('views.task.index.actions') }}</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
                <tr class="border-b border-dashed text-left">
                    <td>{{ $task->id }}</td>
                    <td>{{ $task->status->name }}</td>
                    <td><a href="{{ route('tasks.show', $task) }}"
                            class="text-blue-600 hover:text-blue-900">{{ $task->name }}</a></td>
                    <td>{{ $task->author->name }}</td>
                    <td>{{ $task->executor ? $task->executor->name : null }}</td>
                    <td>{{ date('d.m.Y', strtotime($task->created_at)) }}</td>
                    @if (Auth::check())
                        <td>
                            <a href="{{ route('tasks.edit', $task) }}"
                                class="text-blue-600 hover:text-blue-900">{{ __('views.task.index.update') }}</a>
                        </td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</x-app-layout>
