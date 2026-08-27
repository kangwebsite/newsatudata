<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Forms\Components\TurnstileVerification;
use App\Rules\Turnstile;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Schemas\Schema;

class Login extends BaseLogin
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getRememberFormComponent(),
                TurnstileVerification::make('turnstile')->hiddenLabel()->required()->rules([new Turnstile()])
            ]);
    }

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             $this->getEmailFormComponent(),
    //             $this->getPasswordFormComponent(),
    //             $this->getRememberFormComponent(),
    //             Turnstile::make('turnstile')
    //                 ->label('')
    //                 ->rules([new TurnstileRule()])
    //                 ->required(),
    //         ])
    //         ->statePath('data');
    // }
}