<?php

use App\Livewire\Dataset;
use App\Livewire\DokumentasiApi;
use App\Livewire\GeoportalPage;
use App\Livewire\Homepage;
use App\Livewire\MetadataDetailPage;
use App\Livewire\MetadataPage;
use App\Livewire\News;
use App\Livewire\Pengaduan;
use App\Livewire\Sektoral;
use App\Livewire\SinglePost;
use App\Livewire\SingleTag;
use App\Livewire\Tentang;
use App\Livewire\ViewDataset;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class);
Route::get('/sektoral', Sektoral::class);
Route::get('/dataset', Dataset::class);
Route::get('/dataset/{dataset:slug}', ViewDataset::class);
Route::get('/dokumentasi', DokumentasiApi::class);
Route::get('/publikasi', News::class);
Route::get('/publikasi/tag/{slug}', SingleTag::class);
Route::get('/publikasi/post/{post:slug}', SinglePost::class);
Route::get('/pengaduan', Pengaduan::class);
Route::get('/geoportal', GeoportalPage::class);
Route::get('/metadata', MetadataPage::class);
Route::get('/metadata/{metadata}', MetadataDetailPage::class);
Route::get('/tentang', Tentang::class);
