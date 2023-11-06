<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Income extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'judul' => $this->title,
            'category' => [
                'name' => $this->category->name, // Hanya menampilkan kolom 'name' dari objek kategori
            ],
            // tambahkan kolom lain yang ingin Anda sertakan di sini
        ];
    }
}
