<?php

namespace App\Filament\Resources\Datasets\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class DatasetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('slug'),
                TextEntry::make('description')
                    ->columnSpanFull(),
                TextEntry::make('category_id')
                    ->numeric(),
                TextEntry::make('periode_id')
                    ->numeric(),
                TextEntry::make('type_id')
                    ->numeric(),
                TextEntry::make('file')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('upload_by')
                    ->numeric(),
                TextEntry::make('dataStatus')->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
