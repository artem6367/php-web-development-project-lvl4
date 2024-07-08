<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.label.create.header') }}</x-slot>
    <form method="POST" action="{{ route('labels.store') }}">
        @include('labels.form', ['label' => $label])

        <div class="mt-2">
            <x-primary-button>
                {{ __('views.label.create.toCreate') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>