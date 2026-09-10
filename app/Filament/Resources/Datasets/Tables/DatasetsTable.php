<?php

namespace App\Filament\Resources\Datasets\Tables;

use App\Filament\Imports\DatasetImporter;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DatasetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->modifyQueryUsing(function ($query){
                if (!in_array(Auth::user()->role->value, ['admin', 'bps'])){
                    return $query->with(['uploadBy', 'typeData', 'periodeData', 'categoryData'])->where('upload_by', Auth::id());
                }else{
                    return $query->with(['uploadBy', 'typeData', 'periodeData', 'categoryData']);
                }
            })
            ->columns([
                TextColumn::make('name')->label('Judul Dataset')->searchable()->limit(20)->weight(FontWeight::Bold),
                TextColumn::make('categoryData.name')->sortable()->label('Kategori')->badge()->color('info'),
                TextColumn::make('periodeData.name')->placeholder('-'),
                TextColumn::make('typeData.name'),
                TextColumn::make('uploadBy.name')->label('User')->weight(FontWeight::Bold)->limit(30),
                TextColumn::make('file')
                    ->formatStateUsing(fn (?string $state): string => 
                        $state && Storage::disk('public')->exists($state) ? 'Found' : 'File Not Found'
                    )
                    ->color(fn ($record): string => 
                        $record->file && Storage::disk('public')->exists($record->file) ? 'primary' : 'danger'
                    )
                    ->weight(FontWeight::Bold),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->headerActions([
                //
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ActionGroup::make([
                    Action::make('approved')->icon(Heroicon::OutlinedCheckCircle)->requiresConfirmation()->color('info')->action(fn ($record) => $record->update(['status' => 'approved']))->visible(auth()->user()->role->value === 'admin'),

                    Action::make('verified')->icon(Heroicon::OutlinedCheckCircle)->requiresConfirmation()->color('info')->action(fn ($record) => $record->update(['status' => 'verified']))->visible(auth()->user()->role->value === 'bps'),
                    Action::make('rejected')->icon(Heroicon::OutlinedXCircle)->requiresConfirmation()->color('danger')->action(fn ($record) => $record->update(['status' => 'rejected']))->visible(auth()->user()->role->value === 'bps'),
                    ViewAction::make(),
                    EditAction::make(),
                ])->button()->outlined()->size('sm')
            ])
            ->toolbarActions([
                ImportAction::make()->importer(DatasetImporter::class)->icon(Heroicon::OutlinedArrowDownTray),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
