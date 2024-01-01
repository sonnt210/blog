<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SearchBox extends Component
{
    /** @var string */
    public $search = '';

    public function update()
    {
        $this->dispatch('search', search: $this->search);
    }

    public function render()
    {
        return view('livewire.search-box');
    }
}
