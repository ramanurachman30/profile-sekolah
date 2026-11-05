<?php

namespace App\Filament\Pages\Auth;

use App\Models\SchoolProfile;
use Filament\Actions\Action;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Component as FormComponent;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Support\Enums\IconPosition;
use Filament\Support\Enums\Width;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Validation\ValidationException;
use SensitiveParameter;

class Login extends BaseLogin
{
    protected string $view = 'filament.pages.auth.login';

    protected Width|string|null $maxWidth = Width::FiveExtraLarge;

    public function getTitle(): string|Htmlable
    {
        return 'Login Portal Manajemen — SDN Cikereteg 01';
    }

    public function getHeading(): string|Htmlable|null
    {
        return 'Masuk ke Portal Manajemen';
    }

    public function getSubheading(): string|Htmlable|null
    {
        return 'Gunakan akun resmi pendidik atau tenaga kependidikan SDN Cikereteg 01';
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('login')
            ->label('Username atau Email Resmi')
            ->placeholder('Contoh: superadmin / admin_tu / guru_humas')
            ->prefixIcon('heroicon-m-user')
            ->required()
            ->autocomplete('username')
            ->autofocus()
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        /** @var TextInput $component */
        $component = parent::getPasswordFormComponent();

        return $component
            ->label('Kata Sandi')
            ->placeholder('Masukkan kata sandi akun Anda')
            ->prefixIcon('heroicon-m-lock-closed')
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function getRememberFormComponent(): Component
    {
        /** @var FormComponent $component */
        $component = parent::getRememberFormComponent();

        return $component
            ->label('Tetap masuk di perangkat ini');
    }

    protected function getAuthenticateFormAction(): Action
    {
        return parent::getAuthenticateFormAction()
            ->label('Masuk ke Dashboard')
            ->icon('heroicon-m-arrow-right-end-on-rectangle')
            ->iconPosition(IconPosition::After);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.login' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }

    /**
     * Mengisi kredensial peran demo secara instan.
     */
    public function fillRoleAccount(string $username): void
    {
        $allowedRoles = ['superadmin', 'admin_tu', 'guru_humas', 'panitia_ppdb'];

        if (! in_array($username, $allowedRoles, true)) {
            return;
        }

        $this->data['login'] = $username;
        $this->data['password'] = 'password123';
    }

    /**
     * Mengambil profil sekolah untuk ditampilkan pada panel informasi login.
     */
    public function getSchoolProfileProperty(): ?SchoolProfile
    {
        return SchoolProfile::with('logo')->first();
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        $loginField = filter_var($data['login'], FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        return [
            $loginField => $data['login'],
            'password' => $data['password'],
        ];
    }
}
