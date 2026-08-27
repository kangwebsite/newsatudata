<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class News extends Component
{
    use WithPagination;

    public $query = '';
    public $sort = 'latest';

    #[Computed]
    public function news()
    {
        return Post::query()
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

    #[Computed]
    public function latestPost()
    {
        return Post::latest()->first();
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

    public function render()
    {
        return view('livewire.news')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Publikasi',
                description: 'Kumpulan informasi terbaru, agenda kegiatan, artikel teknis, dan rilis resmi terkait data dan penyelenggaraan Satu Data di Kabupaten Way Kanan.'
            )
        ]);
    }
}
