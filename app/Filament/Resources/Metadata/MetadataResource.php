<?php

namespace App\Filament\Resources\Metadata;

use App\Filament\Resources\Metadata\Pages\ManageMetadata;
use App\Models\Metadata;
use App\Models\User;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MetadataResource extends Resource
{
    protected static ?string $model = Metadata::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label('Nama Kegiatan')
                    ->required(),
                Select::make('tahun')
                    ->options([
                        '2020' => '2020',
                        '2021' => '2021',
                        '2022' => '2022',
                        '2023' => '2023',
                        '2024' => '2024',
                        '2025' => '2025',
                        '2026' => '2026',
                        '2027' => '2027',
                    ])
                    ->default('2026')
                    ->native(false)
                    ->required(),
                TextInput::make('sektor_kegiatan')
                    ->required(),
                TextInput::make('jenis_statistik')
                    ->required(),
                Select::make('produsen_data')
                    ->options(User::where('role', 'user')->pluck('name', 'id'))
                    ->searchable()
                    ->required(),
                TextInput::make('identitas_rekomendasi')
                    ->required(),
                FileUpload::make('file')
                    ->directory('datastore')
                    ->acceptedFileTypes(['application/pdf'])
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('tahun')
                    ->searchable(),
                TextColumn::make('sektor_kegiatan')
                    ->searchable(),
                TextColumn::make('jenis_statistik')
                    ->searchable(),
                TextColumn::make('user.name')->label('Produsen data')
                    ->searchable(),
                TextColumn::make('identitas_rekomendasi')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageMetadata::route('/'),
        ];
    }
}
