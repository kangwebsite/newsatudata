<?php

namespace App\Filament\Imports;

use App\Models\User;
use Filament\Actions\Imports\Exceptions\RowImportFailedException;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Number;

class UserImporter extends Importer
{
    protected static ?string $model = User::class;

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('email')
                ->requiredMapping()
                ->rules(['required', 'email', 'max:255']),
            ImportColumn::make('password')
                ->requiredMapping()
                ->rules(['required', 'max:255']),
            ImportColumn::make('photo')->castStateUsing(fn ($state) => (blank($state) || $state === 'NULL' || $state === null) ? null : $state)
                ->rules(['max:255', 'nullable']),
            ImportColumn::make('role')
                ->requiredMapping()
                ->rules(['required']),
            ImportColumn::make('category_account_id')->castStateUsing(fn ($state) => (blank($state) || $state === 'NULL' || $state === null) ? null : $state),
            ImportColumn::make('address')->castStateUsing(fn ($state) => (blank($state) || $state === 'NULL' || $state === null) ? null : $state),
            ImportColumn::make('phone')
                ->rules(['max:255'])->castStateUsing(fn ($state) => (blank($state) || $state === 'NULL' || $state === null) ? null : $state),
            ImportColumn::make('status')
                ->requiredMapping()
                ->boolean()
                ->rules(['required', 'boolean']),
        ];
    }

    public function resolveRecord(): User
    {
        if ($this->data['email'] === 'diskominfowk@gmail.com') {
            throw new RowImportFailedException('Email diskominfowk@gmail.com diabaikan dan tidak diimport.');
        }

        return User::firstOrNew([
            'email' => $this->data['email'],
        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your user import has completed and ' . Number::format($import->successful_rows) . ' ' . str('row')->plural($import->successful_rows) . ' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' ' . Number::format($failedRowsCount) . ' ' . str('row')->plural($failedRowsCount) . ' failed to import.';
        }

        return $body;
    }
}
