<?php

use Livewire\Volt\Component;
use Livewire\Attributes\{Title};
use Livewire\Attributes\Validate;

new
#[Title('Dashboard')]
class extends Component {

    use \Livewire\WithPagination;

    public $headers = [
        ['key' => 'id', 'label' => 'Table ID'],
        ['key' => 'name', 'label' => 'Table Name'],
        ['key' => 'endpoint', 'label' => 'Endpoint'],
        ['key' => 'created_at', 'label' => 'Created At']
    ];

    public function with(): array
    {
        return [
            'mockTables' => auth()->user()->mockTables()->paginate(10),
        ];
    }

    public function delete($id){
        \App\Models\MockTable::find($id)->delete();
    }

}; ?>

<div>
    <x-mary-table :headers="$headers" :rows="$mockTables" striped with-pagination >

        @scope('cell_created_at', $row)
        {{ $row->created_at->diffForHumans() }}
        @endscope

        @scope('cell_endpoint', $row)
        /v1/custom?tableID={{ $row->id }}&API_KEY=....
        @endscope

        @scope('actions', $table)
        <div class="flex flex-row gap-x-2">
            <x-mary-button icon="o-pencil" wire:navigate href="{{route('editTable', $table->id)}}" spinner class="btn-primary btn-sm" />
            <x-mary-button icon="o-trash" wire:click="delete({{ $table->id }})" spinner class="btn-warning btn-sm" />
        </div>

        @endscope

    </x-mary-table>
</div>
