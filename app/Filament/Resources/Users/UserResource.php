<?php

namespace App\Filament\Resources\Users;

use App\Filament\Exports\UserExporter;
use App\Filament\Imports\UserImporter;
use App\Filament\Resources\Users\Pages\ManageUsers;
use App\Models\User;
use BackedEnum;
use Filament\Actions\ActionGroup;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ExportAction;
use Filament\Actions\ImportAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Schema;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use STS\FilamentImpersonate\Actions\Impersonate;
use UnitEnum;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static string | UnitEnum | null $navigationGroup = 'Management User';
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserCircle;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Group::make([
                    TextInput::make('name')->required()->placeholder('Masukkan nama user'),
                    TextInput::make('email')->label('Email address')->email()->required()->unique('users', 'id', ignoreRecord: true)->placeholder('Masukkan email user'),
                    TextInput::make('password')->placeholder('Masukkan password user')
                        ->revealable()
                        ->password()
                        ->required(fn(string $operation): bool => $operation === 'create')
                        ->saved(fn(?string $state): bool => filled($state))
                        ->dehydrateStateUsing(fn(string $state): string => Hash::make($state)),
                    Textarea::make('address')->columnSpanFull()->placeholder('Masukkan alamat user'),
                    Select::make('role')
                        ->options(['admin' => 'Admin', 'bps' => 'Bps', 'user' => 'User'])
                        ->native(false)
                        ->default('user')
                        ->required(),
                    TextInput::make('phone')->tel()->placeholder('Cth: 62812345XXXX'),
                    Select::make('category_account_id')->relationship('categoryAccount', 'name')->native(false),

                ])->columnSpan(2)->columns(3),

                Group::make([
                    Toggle::make('status')->required(),
                    FileUpload::make('photo')->image()->directory('profiles'),
                ])
            ])->columns(3);
    }

    public static function infolist(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('name'),
                TextEntry::make('email')
                    ->label('Email address'),
                TextEntry::make('email_verified_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('photo')
                    ->placeholder('-'),
                TextEntry::make('role')
                    ->badge(),
                TextEntry::make('category_account_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('address')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('phone')
                    ->placeholder('-'),
                IconEntry::make('status')
                    ->boolean(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn($query) => $query->where('id', '!=', Auth::id()))
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->searchable()->weight(FontWeight::Bold),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                ImageColumn::make('photo')->alt('User photo')->circular()->defaultImageUrl(url('storage/default-profile.png')),
                TextColumn::make('role')->badge(),
                TextColumn::make('categoryAccount.name')->placeholder('-')->badge()->label('Kategori Akun'),
                TextColumn::make('phone')
                    ->searchable(),
                IconColumn::make('status')
                    ->boolean(),
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
                ActionGroup::make([
                    Impersonate::make(),
                    ViewAction::make()->color('info'),
                    EditAction::make()->modalWidth(Width::FiveExtraLarge)->color('warning'),
                    DeleteAction::make(),
                ])->button()->outlined()->size('sm')
            ])
            ->toolbarActions([
                ImportAction::make()->importer(UserImporter::class)->icon(Heroicon::OutlinedArrowDownTray),
                ExportAction::make()->exporter(UserExporter::class)->icon(Heroicon::OutlinedArrowUpTray),
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageUsers::route('/'),
        ];
    }
}
