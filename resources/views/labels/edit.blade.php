<x-app-layout>
    <x-slot name="title">Менеджер задач</x-slot>
    <x-slot name="header">{{ __('views.label.edit.header') }}</x-slot>
    <form method="POST" action="{{ route('labels.update', $label) }}">
        <input type="hidden" name="_method" value="PATCH">
        @include('labels.form', ['label' => $label])

        <div class="mt-2">
            <x-primary-button>
                {{ __('views.label.edit.toUpdate') }}
            </x-primary-button>
        </div>
    </form>
</x-app-layout>
