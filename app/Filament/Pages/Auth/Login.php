<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;
use Filament\Forms\Form;
use Filament\Forms\Components\Checkbox; // Kita import komponen Checkbox manual
use Filament\Actions\Action;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'Selamat Datang';
    }

    // Kita menyusun ulang form-nya secara manual agar tidak ada error pemanggilan fungsi
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent()->label('Alamat Email'),
                $this->getPasswordFormComponent()->label('Kata Sandi'),
                
                // --- BAGIAN ANTI ERROR ---
                // Kita tidak memanggil fungsi bawaan, tapi membuat Checkbox baru.
                // Nama 'remember' adalah kunci agar fitur "Remember Me" tetap jalan.
                Checkbox::make('remember')
                    ->label('Ingat Saya'),
            ])
            ->statePath('data');
    }

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label('Masuk');
    }
}