<?php

use Livewire\Attributes\Validate;
use Livewire\Volt\Component;

new class extends Component
{

    public \App\Models\MockTable $table;

    #[Validate('required')]
    public string $tableName = '';
    #[Validate('required')]
    public array $fields = array();
    public $options = [
        ['id' => 'fake()->name', 'name' => 'Random Name'],
        ['id' => 'fake()->date','name' => 'Random Date'],
        ['id' => 'fake()->streetAddress','name' => 'Random Street Address'],
        ['id' => 'fake()->randomNumber','name' => 'Random ID'],
        ['id' => 'fake()->boolean','name' => 'Random Boolean'],
        ['id' => 'fake()->paragraph','name' => 'Random Paragraph'],
        ['id' => 'fake()->sentence','name' => 'Random Sentence'],
        ['id' => 'fake()->safeEmail','name' => 'Random Email'],
       ['id' => 'fake()->url','name' => 'Random Url'],
        ['id' => 'fake()->phoneNumber','name' => 'Random Phone Number'],
        ['id' => 'fake()->company','name' => 'Random Company'],
        ['id' => 'fake()->jobTitle','name' => 'Random Job Title'],
    ];
    public function save(){
        $validated = $this->validate();

        $createdMockTable = auth()->user()->mockTables()->create([
            "name" => $validated['tableName'],
        ]);

        foreach ($this->fields as $field){
            if($field->name != '' && $field->generator != ''){
                $createdMockTable->mockFields()->create([
                    'name' => $field->name,
                    'generator' => $field->generator
                ]);
            }

        }
        return $this->redirect('dashboard');
    }

    public function addField(){
        $this->fields[] = (object) ['name' => '', 'generator' => ''];
    }

    public function deleteField($index){
        unset($this->fields[$index]);
    }

}; ?>

<div>
    <x-mary-form wire:submit="save">
        @error('fields') <span class="text-red-500">You need to add at least 1 field</span> @enderror
        <x-mary-input label="Table Name" wire:model="tableName"/>

        @foreach($fields as $key => $field)
            <div class="flex gap-x-4 items-end">
                <x-mary-input class="flex-initial" label="Field Name" wire:model="fields.{{$key}}.name"/>
                <x-mary-select label="Type" :options="$options" wire:model="fields.{{$key}}.generator" placeholder="Select a random value type" placeholder-value="" />
                <x-mary-button icon="o-trash" type="button" wire:click="deleteField({{$key}})" class="flex-initial btn-warning btn btn-circle" />
            </div>

        @endforeach

        <x-slot:actions>
            <x-mary-button wire:click="addField" label="Add Field" class="btn" spinner="save" />
            <x-mary-button label="Save" class="btn-primary" type="submit" spinner="save" />
        </x-slot:actions>
    </x-mary-form>
</div>
