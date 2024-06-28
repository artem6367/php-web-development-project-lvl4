<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.task.edit.header') }}</x-slot>
    <form method="POST" action="{{ route('tasks.update', $task) }}">
        <input type="hidden" name="_method" value="PATCH">
        @include('tasks.form', ['task' => $task])

        <div class="mt-2">
            <x-primary-button>
                {{ __('views.task.edit.toUpdate') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
