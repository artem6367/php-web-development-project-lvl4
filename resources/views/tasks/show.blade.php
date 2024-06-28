<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">
        {{ __('views.task.show.header') }}: {{ $task->name }}
        <a href="{{ route('tasks.edit', $task) }}">⚙</a>
    </x-slot>
    <p>
        <span class="font-black">{{ __('models.task.name') }}:</span>
        {{ $task->name }}
    </p>
    <p>
        <span class="font-black">{{ __('models.task.status') }}:</span>
        {{ $task->status->name }}
    </p>
    <p>
        <span class="font-black">{{ __('models.task.description') }}:</span>
        {{ $task->description }}
    </p>
</x-app-layout>
