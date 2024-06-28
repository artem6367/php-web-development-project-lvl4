<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.status.create.header') }}</x-slot>
    <form method="POST" action="{{ route('task_statuses.store') }}">
        @csrf

        <div>
            <x-input-label class="mt-2" for="name" :value="__('models.status.name')" />
            <x-text-input id="name" class="block mt-1 w-1/3" type="text" name="name" :value="$status->name"
                autofocus />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>
        <div class="mt-2">
            <x-primary-button>
                {{ __('views.status.create.toCreate') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
