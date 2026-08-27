<?php

namespace App\Livewire;

use App\Models\Report;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use RalphJSmit\Laravel\SEO\Support\SEOData;

class Pengaduan extends Component
{
    public $name;
    public $organisation;
    public $email;
    public $phone;
    public $category;
    public $url;
    public $description;
    public $turnstileToken;

    public function submit()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'organisation' => 'nullable|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'category' => 'required|string|in:data_salah,data_kadaluarsa,permohonan_data,bug_sistem,lainnya',
            'url' => 'nullable|url|max:255',
            'description' => 'required|string',
            'turnstileToken' => 'required|string',
        ]);

        $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret_key'),
            'response' => $this->turnstileToken,
            'remoteip' => request()->ip(),
        ]);

        if (!$response->json('success')) {
            throw ValidationException::withMessages([
                'turnstileToken' => 'Validasi keamanan gagal, silakan coba lagi.',
            ]);
        }

        Report::create([
            'name' => $this->name,
            'organisation' => $this->organisation,
            'email' => $this->email,
            'phone' => $this->phone,
            'category' => $this->category,
            'url' => $this->url,
            'description' => $this->description,
        ]);

        $this->reset();

        session()->flash('message', 'Form berhasil dikirim!');
    }

    public function render()
    {
        return view('livewire.pengaduan')->layout('layouts::app', [
            'SEOData' => new SEOData(
                title: 'Pengaduan',
                description: 'Jika Anda menemukan masalah pada data, aplikasi, atau ingin mengajukan permohonan dataset baru, silakan isi formulir di bawah ini.'
            )
        ]);
    }
}
