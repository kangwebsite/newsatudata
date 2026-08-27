<?php

namespace App\Filament\Resources\Datasets\Schemas;

use App\DatasetStatuses;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DatasetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make([
                    TextInput::make('name')->placeholder('Cth: Data Menara BTS')->required()->label('Judul Data'),
                    Select::make('category_data_id')->relationship('categoryData', 'name')->native(false)->required()->label('Kategori Data'),
                    Select::make('type_data_id')->relationship('typeData', 'name')->preload()->native(false)->required()->label('Tipe Data'),
                    Textarea::make('description')
                        ->label('Deskripsi Dataset')
                        ->placeholder('Cth: Data lokasi BTS di kabupaten way kanan')
                        ->required()
                        ->columnSpanFull(),
                ])->columns(3)->columnSpan(3),
                Section::make([
                    Select::make('periode_data_id')->relationship('periodeData', 'name')->native(false)->columnSpan(1),
                    FileUpload::make('file')->directory('datastore')->required(),
                ])->columns(1)->columnSpan(1)
            ])->columns(4);
    }
}
