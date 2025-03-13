<?php

namespace App\Filament\Resources;

use App\Filament\Resources\KategoriResource\Pages;
use App\Models\Kategori;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class KategoriResource extends Resource
{
    protected static ?string $model = Kategori::class;
    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $pluralLabel = 'Kategori';
    protected static ?string $slug = 'Kategori';
    protected static ?string $navigationLabel = 'Kategori Barang';
    protected static ?string $navigationGroup = 'Manajemen Barang';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                TextInput::make('nama_kategori')
                    ->label('Nama Kategori')
                    ->required()
                    ->unique(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_kategori')->label('Nama Kategori'),
            ])
            ->actions([
                EditAction::make(),  // Tombol Edit
                DeleteAction::make(), // Tombol Delete
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListKategori::route('/'),
            'create' => Pages\CreateKategori::route('/create'),
            'edit' => Pages\EditKategori::route('/{record}/edit'),
        ];
    }
}
