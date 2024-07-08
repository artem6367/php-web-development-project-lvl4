<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.status.edit.header') }}</x-slot>

    <form method="POST" action="{{ route('task_statuses.update', $task_status) }}">
        @csrf
        <input type="hidden" name="_method" value="PATCH">

        <div>
            <x-input-label class="mt-2" for="name" :value="__('models.status.name')" />
            <x-text-input id="name" class="block mt-2 w-1/3" type="text" name="name" :value="$task_status->name"
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mt-2">
            <x-primary-button>
                {{ __('views.status.edit.toUpdate') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
