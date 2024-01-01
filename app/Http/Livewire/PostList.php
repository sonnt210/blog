<?php

namespace App\Http\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class PostList extends Component
{
    use WithPagination;

    #[Url()]
    public $sort = 'desc';
    #[Url()]
    public $search = '';

    public function setSort(string $sort)
    {
        $this->sort = ($sort === 'desc') ? 'desc' : 'asc';
    }

    #[On('search')]
    public function updateSearch(string $search)
    {
        $this->search = $search;
    }

    #[Computed()]
    public function posts()
    {
        return Post::published()
            ->where('title', 'like', "%{$this->search}%")
            ->orderBy('published_at', $this->sort)
            ->paginate(5);
    }

    public function render()
    {
        return view('livewire.post-list');
    }
}
