<?php

namespace App\Filament\Resources\BarangResource\Pages;

use App\Filament\Resources\BarangResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use Illuminate\Support\Facades\Log;

class CreateBarang extends CreateRecord
{
    protected static string $resource = BarangResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    Log::info('Data sebelum disimpan:', $data); // Debugging kategori_id
    dd($data); // Tambahkan ini untuk melihat hasil di layar
    return $data;
}

}

