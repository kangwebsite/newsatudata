<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SingleTag extends Component
{
    use WithPagination;

    public $query = '';
    public $sort = 'latest';

    public $slug;
    public $searchTag;

    public function mount($slug)
    {
        abort_if(!preg_match('/^[a-z0-9\-]+$/', $slug), 404);

        $this->slug = $slug;
        $this->searchTag = str_replace('-', ' ', $slug);

        $tagExists = Post::whereJsonContains('tags', $this->searchTag)
            ->orWhereJsonContains('tags', Str::title($this->searchTag))
            ->orWhereJsonContains('tags', $this->slug)
            ->exists();

        abort_if(!$tagExists, 404);
    }

    #[Computed]
    public function tags()
    {
        return Post::pluck('tags')->flatten()->map(fn($item) => strtolower(trim($item)))->unique()->values();
    }

    #[Computed]
    public function popularPosts()
    {
        return Post::orderByDesc('viewCount')->take(5)->get();
    }

    #[Computed]
    public function posts()
    {
        return Post::query()
            ->whereJsonContains('tags', $this->searchTag)
            ->orWhereJsonContains('tags', Str::title($this->searchTag))
            ->orWhereJsonContains('tags', $this->slug)
            ->when($this->query, function ($q) {
                $q->where('title', 'like', "%{$this->query}%")->orWhere('body', 'like', "%{$this->query}%");
            })
            ->when($this->sort === 'latest', function ($q) {
                $q->orderBy('created_at', 'desc');
            })
            ->when($this->sort === 'oldest', function ($q) {
                $q->orderBy('created_at', 'asc');
            })
            ->when($this->sort === 'az', function ($q) {
                $q->orderBy('title', 'asc');
            })
            ->paginate(10);
    }

    public function render()
    {
        return view('livewire.single-tag')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Cari data berdasarkan tag #' . $this->searchTag
            )
        ]);
    }
}