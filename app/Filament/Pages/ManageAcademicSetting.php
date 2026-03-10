<?php

namespace App\Filament\Pages;

use App\Settings\AcademicSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageAcademicSetting extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Settings';
    protected static ?string $title = 'Batas Kelulusan TOEFL';
    protected static string $settings = AcademicSetting::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Pengaturan Pass Grade TOEFL')
                    ->description('Tentukan skor minimum TOEFL agar mahasiswa di level tersebut dapat menjadi kandidat terbaik.')
                    ->schema([
                        Forms\Components\TextInput::make('min_toefl_d3')
                            ->label('Batas Minimum TOEFL (Level D3)')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('min_toefl_s1')
                            ->label('Batas Minimum TOEFL (Level S1)')
                            ->numeric()
                            ->required(),
                        Forms\Components\TextInput::make('min_toefl_s2')
                            ->label('Batas Minimum TOEFL (Level S2)')
                            ->numeric()
                            ->required(),
                    ])
                    ->columns(3),
            ]);
    }
}
