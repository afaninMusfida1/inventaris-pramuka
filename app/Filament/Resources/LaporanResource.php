<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LaporanResource\Pages;
use App\Models\Laporan;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Resources\Resource;

class LaporanResource extends Resource
{
    protected static ?string $model = Laporan::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Laporan Peminjaman';
    protected static ?string $pluralLabel = 'Laporan Peminjaman';
    protected static ?string $navigationGroup = 'Manajemen Inventaris';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Select::make('peminjaman_id')
                    ->relationship('peminjaman', 'nama_peminjam')
                    ->label('Nama Peminjam')
                    ->searchable()
                    ->required(),

                Select::make('barang_id')
                    ->relationship('barang', 'nama_barang')
                    ->label('Barang yang Dipinjam')
                    ->searchable()
                    ->required(),

                Select::make('status')
                    ->options([
                        'dipinjam' => 'Sedang Dipinjam',
                        'dikembalikan' => 'Dikembalikan',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                TextColumn::make('peminjaman.nama_peminjam')
                    ->label('Nama Peminjam')
                    ->searchable(),

                TextColumn::make('barang.nama_barang')
                    ->label('Barang')
                    ->searchable(),

                BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'danger' => 'dipinjam',
                        'success' => 'dikembalikan',
                    ]),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporan::route('/'),
            'create' => Pages\CreateLaporan::route('/create'),
            'edit' => Pages\EditLaporan::route('/{record}/edit'),
        ];
    }
}
