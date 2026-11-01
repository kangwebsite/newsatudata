<?php

namespace App\Filament\Resources\Roads;

use App\Filament\Actions\ImportRoadsAction;
use App\Filament\Resources\Roads\Pages\ManageRoads;
use App\Models\Road;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\ColorPicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ColorColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class RoadResource extends Resource
{
    protected static ?string $model = Road::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    /**
     * @return array<string, string>
     */
    public static function typeOptions(): array
    {
        return [
            'jalan_nasional' => 'Jalan nasional',
            'jalan_provinsi' => 'Jalan provinsi',
            'jalan_kabupaten' => 'Jalan kabupaten',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make([
                    'default' => 1,
                    'md' => 2,
                ])->schema([
                    TextInput::make('name')
                        ->label('Nama jalan')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),

                    Select::make('type')
                        ->label('Kategori jalan')
                        ->options(static::typeOptions())
                        ->required()
                        ->native(false),

                    ColorPicker::make('warna')
                        ->label('Warna')
                        ->required()
                        ->default('#0f766e'),

                    TextInput::make('lat_a')
                        ->label('Latitude A')
                        ->numeric()
                        ->required()
                        ->minValue(-90)
                        ->maxValue(90)
                        ->step('any')
                        ->placeholder('-4.44470'),

                    TextInput::make('lng_a')
                        ->label('Longitude A')
                        ->numeric()
                        ->required()
                        ->minValue(-180)
                        ->maxValue(180)
                        ->step('any')
                        ->placeholder('104.51260'),

                    TextInput::make('lat_b')
                        ->label('Latitude B')
                        ->numeric()
                        ->required()
                        ->minValue(-90)
                        ->maxValue(90)
                        ->step('any')
                        ->placeholder('-4.44650'),

                    TextInput::make('lng_b')
                        ->label('Longitude B')
                        ->numeric()
                        ->required()
                        ->minValue(-180)
                        ->maxValue(180)
                        ->step('any')
                        ->placeholder('104.51550'),

                    Textarea::make('path_coordinates')
                        ->label('Koordinat rute (JSON)')
                        ->placeholder('[[-4.4447, 104.5126], [-4.4505, 104.5200]]')
                        ->columnSpanFull()
                        ->helperText('Format JSON: array pasang [latitude, longitude]. Titik pertama = A, terakhir = B. Bisa banyak titik untuk rute berkelok.'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama jalan')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('type')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => static::typeOptions()[$state] ?? (string) $state),

                ColorColumn::make('warna')
                    ->label('Warna'),

                TextColumn::make('titik_a')
                    ->label('Titik A (lat, lng)')
                    ->placeholder('—'),

                TextColumn::make('titik_b')
                    ->label('Titik B (lat, lng)')
                    ->placeholder('—'),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make()
                    ->fillForm(fn (Road $record): array => [
                        'name' => $record->name,
                        'type' => $record->type,
                        'warna' => $record->warna,
                        'lat_a' => $record->lat_a,
                        'lng_a' => $record->lng_a,
                        'lat_b' => $record->lat_b,
                        'lng_b' => $record->lng_b,
                        'path_coordinates' => is_array($record->path_coordinates) ? json_encode($record->path_coordinates) : $record->path_coordinates,
                    ]),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                ImportRoadsAction::make('importRoads'),

                Action::make('downloadImportTemplate')
                    ->label('Template CSV')
                    ->icon(Heroicon::OutlinedDocumentArrowDown)
                    ->color('gray')
                    ->tooltip('Unduh contoh file import (kolom: name, type, warna, lat_a, lng_a, lat_b, lng_b)')
                    ->action(function () {
                        return response()->streamDownload(function (): void {
                            $handle = fopen('php://output', 'w');

                            // BOM supaya Excel membaca file sebagai UTF-8.
                            fwrite($handle, "\xEF\xBB\xBF");

                            fputcsv($handle, ['name', 'type', 'warna', 'lat_a', 'lng_a', 'lat_b', 'lng_b']);
                            fputcsv($handle, ['Jalan Lintas Sumatra', 'nasional', '#0f766e', '-4.4447', '104.5126', '-4.4465', '104.5155']);
                            fputcsv($handle, ['Jalan Provinsi Contoh', 'provinsi', '#e11d48', '-4.51', '104.61', '-4.56', '104.66']);

                            fclose($handle);
                        }, 'template-import-jalan.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
                    }),

                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageRoads::route('/'),
        ];
    }
}