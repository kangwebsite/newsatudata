<?php

use Livewire\Component;

use App\Models\Post;

new class extends Component {
    
    public $posts;

    public function mount()
    {
        $this->posts = Post::latest()->limit(4)->get();
    }
    
};
?>

<div class="bg-white rounded-2xl p-6 shadow-gray-200 shadow-lg border border-slate-100 font-sans">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-slate-800 text-lg">Berita & Agenda</h3>
        <a href="/publikasi" wire:navigate class="text-xs text-slate-500 hover:text-brand-600 flex items-center gap-1">Lihat Semua <i class="ph ph-arrow-right"></i></a>
    </div>
    <div class="space-y-4">
        
        @foreach ($this->posts as $post)            
        <div class="flex gap-3 items-start">
            <img src="{{ url('storage/' . $post->image) }}" alt="Thumb" class="w-24 h-18 rounded object-cover shrink-0">
            <div>
                <div class="max-w-[20rem]">
                    @foreach ($post->tags as $tag)
                    <span class="text-[8px] bg-gray-200 text-gray-600 px-1 py-0.5 rounded font-bold uppercase">{{ $tag }}</span>
                    @endforeach
                </div>
                
                <a href="/publikasi/post/{{ $post->slug }}" class="text-sm font-semibold text-slate-800 hover:text-brand-600 line-clamp-2 mt-1 leading-snug">{{ $post->title }}</a>
                <div class="flex items-center gap-2 mt-1 text-xs text-slate-500">
                    <span class="flex items-center gap-0.5"><i class="ph ph-calendar"></i> {{ $post->created_at->translatedFormat('j M Y') }}</span>
                    <span class="flex items-center gap-0.5"><i class="ph ph-eye"></i> {{ number_format($post->viewCount, 0, '.', '.') }}x</span>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>
