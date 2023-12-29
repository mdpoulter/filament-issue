<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required(),

                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required(),

                // Does not show the date at all [not fixed], but saves it 2 hours behind [not fixed]
                Forms\Components\Group::make()
                    ->relationship('date')
                    ->schema([
                        Forms\Components\DateTimePicker::make('date_one')
                            ->hint('Does not show the date at all [not fixed], but saves it 2 hours behind [not fixed]')
                            ->helperText(fn($record) => 'Database: ' . $record->date_one)
                            ->timezone('GMT+2'),
                    ]),

                // Shows the date 4 hours ahead (instead of 2) [fixed], and then saves it 2 hours ahead [fixed]
                Forms\Components\Group::make()
                    ->relationship('date')
                    ->schema([
                        Forms\Components\DateTimePicker::make('date_two')
                            ->hint('Shows the date 4 hours ahead [fixed], and then saves it 2 hours ahead [fixed]')
                            ->helperText(fn($record) => 'Database: ' . $record->date_two)
                            ->timezone('GMT+2')
                            ->native(false),
                        ]),

                // Works correctly
                Forms\Components\DateTimePicker::make('created_at')
                    ->hint('Works correctly')
                    ->helperText(fn($record) => 'Database: ' . $record->created_at)
                    ->timezone('GMT+2')
                    ->native(false),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
