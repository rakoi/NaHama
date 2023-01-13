<?php

namespace App\Filament\Resources\TownResourseResource\RelationManagers;

use App\Models\Size;
use App\Models\Town;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PropertyRelationManager extends RelationManager
{
    protected static string $relationship = 'Property';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('user_id')
                    ->label('User')
                    ->options(User::where('id',Auth::user()->id)->pluck('name', 'id'))
                    ->searchable(),
                Select::make('sizes_id')
                    ->label('Size')
                    ->options(Size::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('town_id')
                    ->label('Town')
                    ->options(Town::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\TextInput::make('title'),
                RichEditor::make('description')->required(),
                Forms\Components\TextInput::make('contact'),
                Forms\Components\Toggle::make('is_available')->required()

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('town.name'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('contact'),
                Tables\Columns\BooleanColumn::make('is_available'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
}
