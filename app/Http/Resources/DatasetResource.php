<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DatasetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'slug' => $this->slug,
            'description' => $this->description,
            'file' => $this->file ? url('storage/' . $this->file) : null,
            'organization' => $this->whenLoaded('uploadBy', function () {
                return $this->uploadBy->name;
            }),
            'topik' => $this->whenLoaded('categoryData', function () {
                return $this->categoryData->name;
            }),
            'periode' => $this->whenLoaded('periodeData', function () {
                return $this->periodeData->name;
            }),
            'tipe_data' => $this->whenLoaded('typeData', function () {
                return $this->typeData->name;
            }),
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
