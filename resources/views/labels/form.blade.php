@csrf

<div>
    <x-input-label class="mt-2" for="name" :value="__('models.label.name')" />
    <x-text-input id="name" class="block mt-1 w-1/3" type="text" name="name" :value="$label->name" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label class="mt-2" for="description" :value="__('models.label.description')" />
    <x-textarea id="description" class="block mt-1 w-1/3" name="description">
        {{ $label->description }}
    </x-textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>
