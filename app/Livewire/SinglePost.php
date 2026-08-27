<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Attributes\Computed;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class SinglePost extends Component
{
    public Post $post;

    #[Computed]
    public function tags()
    {
        return Post::pluck('tags')->flatten()->map(fn($item) => strtolower(trim($item)))->unique()->values();
    }

    #[Computed]
    public function popularPosts()
    {
        return Post::where('id', '!=', $this->post->id)->orderByDesc('viewCount')->take(10)->get();
    }

    #[Computed]
    public function bacaJuga()
    {
        return Post::where('id', '!=', $this->post->id)->inRandomOrder()->limit(2)->get();
    }

    public function render()
    {
        return view('livewire.single-post')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: $this->post->title,
                description: $this->post->excerpt,
                image: url('storage/' . $this->post->image)
            )
        ]);
    }
}
