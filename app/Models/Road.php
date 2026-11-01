<?php

namespace App\Models;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use Cachable;

    protected $guarded = ['id'];

    protected $casts = [
        'path_coordinates' => 'array',
    ];

    /**
     * Koordinat jalan disimpan pada kolom `path_coordinates` dengan format
     * [[lat, lng], [lat, lng]]. Accessor & mutator di bawah ini membuat
     * titik A dan titik B bisa dipakai langsung sebagai field form.
     */
    public function getLatAAttribute(): ?float
    {
        return $this->coordinate(0, 0);
    }

    public function getLngAAttribute(): ?float
    {
        return $this->coordinate(0, 1);
    }

    public function getLatBAttribute(): ?float
    {
        return $this->coordinate(1, 0);
    }

    public function getLngBAttribute(): ?float
    {
        return $this->coordinate(1, 1);
    }

    public function setLatAAttribute(mixed $value): void
    {
        $this->setCoordinate(0, 0, $value);
    }

    public function setLngAAttribute(mixed $value): void
    {
        $this->setCoordinate(0, 1, $value);
    }

    public function setLatBAttribute(mixed $value): void
    {
        $this->setCoordinate(1, 0, $value);
    }

    public function setLngBAttribute(mixed $value): void
    {
        $this->setCoordinate(1, 1, $value);
    }

    /**
     * Titik A yang sudah diformat untuk ditampilkan di tabel.
     */
    public function getTitikAAttribute(): string
    {
        return $this->formatPoint(0);
    }

    /**
     * Titik B yang sudah diformat untuk ditampilkan di tabel.
     */
    public function getTitikBAttribute(): string
    {
        return $this->formatPoint(-1);
    }

    protected function coordinate(int $point, int $axis): ?float
    {
        $value = $this->path_coordinates[$point][$axis] ?? null;

        return is_numeric($value) ? (float) $value : null;
    }

    protected function setCoordinate(int $point, int $axis, mixed $value): void
    {
        $coordinates = $this->path_coordinates;
        $coordinates = is_array($coordinates) ? array_values($coordinates) : [];

        while (count($coordinates) < 2) {
            $coordinates[] = [null, null];
        }

        $coordinates[$point] = array_pad(array_values((array) $coordinates[$point]), 2, null);
        $coordinates[$point][$axis] = is_numeric($value) ? (float) $value : null;

        $this->path_coordinates = $coordinates;
    }

    protected function formatPoint(int $index): string
    {
        $coordinates = is_array($this->path_coordinates) ? array_values($this->path_coordinates) : [];

        if ($index === -1) {
            $index = array_key_last($coordinates) ?? 0;
        }

        $point = $coordinates[$index] ?? null;

        if (! is_array($point) || count(array_filter($point, 'is_numeric')) < 2) {
            return '—';
        }

        return number_format((float) $point[0], 5, '.', '') . ', ' . number_format((float) $point[1], 5, '.', '');
    }
}