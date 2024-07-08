<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.task.create.header') }}</x-slot>
    <form method="POST" action="{{ route('tasks.store') }}">
        @include('tasks.form', ['task' => $task])

        <div class="mt-2">
            <x-primary-button>
                {{ __('views.task.create.toCreate') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
