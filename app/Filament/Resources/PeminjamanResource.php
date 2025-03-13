<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PeminjamanResource\Pages;
use App\Models\Peminjaman;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class PeminjamanResource extends Resource
{
    protected static ?string $model = Peminjaman::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Peminjaman';
    protected static ?string $pluralLabel = 'Peminjaman';
    protected static ?string $slug = 'Peminjaman';
    protected static ?string $navigationGroup = 'Manajemen Peminjaman';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nama_peminjam')
                    ->label('Nama Peminjam')
                    ->sortable(),

                TextColumn::make('barang.nama_barang')
                    ->label('Barang yang Dipinjam')
                    ->sortable(),

                // Menampilkan jumlah barang dari PeminjamanUser
                TextColumn::make('peminjamanUser.jumlah')
                ->label('Jumlah Barang')
                ->sortable()
                ->getStateUsing(function (Peminjaman $record) {
                    return $record->peminjamanUser->first()->jumlah ?? 0; // Ambil pertama dari koleksi
                }),

                TextColumn::make('tanggal_peminjaman')
                    ->label('Tanggal Peminjaman')
                    ->sortable(),

                    TextColumn::make('detailPeminjaman.tanggal_pengembalian')
    ->label('Tanggal Pengembalian')
    ->sortable()
    ->getStateUsing(fn (Peminjaman $record) => $record->detailPeminjaman->tanggal_pengembalian ?? '-'),


                BadgeColumn::make('status_peminjaman')
                    ->label('Status')
                    ->colors([
                        'gray' => 'pending',
                        'success' => 'disetujui',
                        'danger' => 'ditolak',
                    ]),
            ])
            ->actions([
                Action::make('setujui')
    ->label('Setujui')
    ->icon('heroicon-o-check-circle')
    ->color('success')
    ->requiresConfirmation()
    ->modalHeading('Konfirmasi Persetujuan')
    ->modalDescription('Apakah Anda yakin ingin menyetujui peminjaman ini?')
    ->modalButton('Ya, Setujui')
    ->action(function (Peminjaman $record) {
        $record->update(['status_peminjaman' => 'disetujui']);

        // Hanya update status peminjaman_user yang terkait dengan peminjaman ini
        \App\Models\PeminjamanUser::where('peminjaman_id', $record->id)
            ->update(['status_peminjaman' => 'disetujui']);
    })
    ->visible(fn (Peminjaman $record) => $record->status_peminjaman === 'pending'),

Action::make('tolak')
    ->label('Tolak')
    ->icon('heroicon-o-x-circle')
    ->color('danger')
    ->requiresConfirmation()
    ->modalHeading('Konfirmasi Penolakan')
    ->modalDescription('Apakah Anda yakin ingin menolak peminjaman ini?')
    ->modalButton('Ya, Tolak')
    ->action(function (Peminjaman $record) {
        $record->update(['status_peminjaman' => 'ditolak']);

        // Hanya update status peminjaman_user yang terkait dengan peminjaman ini
        \App\Models\PeminjamanUser::where('peminjaman_id', $record->id)
            ->update(['status_peminjaman' => 'ditolak']);
    })
    ->visible(fn (Peminjaman $record) => $record->status_peminjaman === 'pending'),

    Action::make('dikembalikan')
    ->label('Sudah Dikembalikan')
    ->icon('heroicon-o-arrow-path')
    ->color('green')
    ->requiresConfirmation()
    ->modalHeading('Konfirmasi Pengembalian')
    ->modalDescription('Apakah barang ini sudah dikembalikan?')
    ->modalButton('Ya, Barang Dikembalikan')
    ->color('success')
    ->action(function (Peminjaman $record) {
        $record->update(['status_peminjaman' => 'dikembalikan']);

        // Update status peminjaman_user terkait
        \App\Models\PeminjamanUser::where('peminjaman_id', $record->id)
            ->update(['status_peminjaman' => 'dikembalikan']);
    })
    ->visible(fn (Peminjaman $record) => $record->status_peminjaman === 'disetujui'),

            ]);
    }
    

    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPeminjaman::route('/'),
        ];
    }
}
