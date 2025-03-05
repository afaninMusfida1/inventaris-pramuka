<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BarangResource\Pages;
use App\Models\Barang;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;

class BarangResource extends Resource
{
    protected static ?string $model = Barang::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box';
    protected static ?string $navigationLabel = 'Barang';
    protected static ?string $navigationGroup = 'Manajemen Barang';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form->schema([
            TextInput::make('nama_barang')->required()->label('Nama Barang'),
            Select::make('kategori_id')
    ->label('Kategori')
    ->options(\App\Models\Kategori::pluck('nama_kategori', 'id')->toArray()) 
    ->searchable()
    ->preload()
    ->required(),

        
           TextInput::make('jumlah_stok')->numeric()->label('Jumlah Stok')->required(),
            Select::make('status')
                ->options([
                    'tersedia' => 'Tersedia',
                    'dipinjam' => 'Dipinjam',
                    'rusak' => 'Rusak',
                    'hilang' => 'Hilang',
                ])
                ->label('Status')
                ->required(),
        ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table->columns([
            TextColumn::make('nama_barang')->label('Nama Barang')->sortable()->searchable(),
            TextColumn::make('kategori.nama_kategori')->label('Kategori')->sortable(), // Mengakses nama kategori lewat relasi
            TextColumn::make('jumlah_stok')->label('Jumlah Stok')->sortable(),
            TextColumn::make('status')->label('Status')->sortable(),
        ])
        ->filters([
            SelectFilter::make('kategori_id')
            ->relationship('kategori', 'nama_kategori')
            ->label('Kategori'),
        ])
        ->actions([
            EditAction::make(),
            DeleteAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBarang::route('/'),
            'create' => Pages\CreateBarang::route('/create'),
            'edit' => Pages\EditBarang::route('/{record}/edit'),
        ];
    }
}
