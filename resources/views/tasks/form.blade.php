@csrf

<div>
    <x-input-label class="mt-2" for="name" :value="__('models.task.name')" />
    <x-text-input id="name" class="block mt-1 w-1/3" type="text" name="name" :value="$task->name" autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>

<div>
    <x-input-label class="mt-2" for="description" :value="__('models.task.description')" />
    <x-textarea id="description" class="block mt-1 w-1/3" name="description">
        {{ $task->description }}
    </x-textarea>
    <x-input-error :messages="$errors->get('description')" class="mt-2" />
</div>

<div>
    <x-input-label class="mt-2" for="status_id" :value="__('models.task.status')" />
    <x-select id="status_id" class="w-1/3" name="status_id" :items=$statuses :value="$task->status_id" />
    <x-input-error :messages="$errors->get('status_id')" class="mt-2" />
</div>

<div>
    <x-input-label class="mt-2" for="assigned_to_id" :value="__('models.task.executor')" />
    <x-select id="assigned_to_id" class="w-1/3" name="assigned_to_id" :items=$users :value="$task->assigned_to_id" />
    <x-input-error :messages="$errors->get('assigned_to_id')" class="mt-2" />
</div>

<div>
    <x-input-label class="mt-2" for="labels" :value="__('models.task.labels')" />
    <x-select-multiple id="labels[]" class="w-1/3 h-32" name="labels[]" :items=$labels :value="$labelValues" />
    <x-input-error :messages="$errors->get('labels')" class="mt-2" />
</div>
