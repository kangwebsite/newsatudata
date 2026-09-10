<?php

namespace App\Filament\Resources\Datasets\Schemas;

use App\Filament\Infolists\Components\FileEntry;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;

class DatasetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Dasar')->schema([
                    TextEntry::make('name')->label('Nama Dokumen')->weight(FontWeight::Bold),
                    TextEntry::make('slug')->label('Slug System')->weight(FontWeight::Bold),
                    TextEntry::make('description')->weight(FontWeight::Bold)
                        ->label('Deskripsi')
                        ->columnSpanFull(),
                ])->columns(2)->columnSpan(1),

                Section::make('Detail Teknis & Klasifikasi')->schema([
                    TextEntry::make('categoryData.name')->label('Kategori')->weight(FontWeight::Bold),
                    TextEntry::make('typeData.name')->label('Tipe Data')->weight(FontWeight::Bold),
                    TextEntry::make('periodeData.name')->label('Periode')->placeholder('-')->weight(FontWeight::Bold),
                    TextEntry::make('status')->badge()->label('Status')->weight(FontWeight::Bold),
                ])->columns(3)->columnSpan(1),

                Section::make('File Dokumen')->schema([
                    FileEntry::make('file')->hiddenLabel()
                ])->columns(1)->columnSpan(1),


                Section::make('Metadata Pengunggahan')->schema([
                    TextEntry::make('uploadBy.name')->label('Diupload Oleh')->weight(FontWeight::Bold),
                    TextEntry::make('created_at')->weight(FontWeight::Bold)
                        ->dateTime()
                        ->label('Dibuat Pada')
                        ->placeholder('-'),
                    TextEntry::make('updated_at')->weight(FontWeight::Bold)
                        ->dateTime()
                        ->label('Diperbarui Pada')
                        ->placeholder('-'),
                ])->columns(3)->columnSpan(1),

            ])->columns(2);
    }
}
