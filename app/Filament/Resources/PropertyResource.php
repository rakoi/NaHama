<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PropertyResource\Pages;
use App\Filament\Resources\PropertyResource\RelationManagers;
use App\Models\Property;
use App\Models\Size;
use App\Models\Town;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

class PropertyResource extends Resource
{
    protected static ?string $model = Property::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
              Forms\Components\Card::make()->schema(
                  [
                      //
                      Select::make('user_id')
                          ->label('User')
                          ->options(User::where('id',Auth::user()->id)->pluck('name', 'id'))
                          ->searchable()->required(),
                      Select::make('sizes_id')
                          ->label('Size')
                          ->options(Size::all()->pluck('name', 'id'))
                          ->searchable()->required(),
                      Select::make('town_id')
                          ->label('Town')
                          ->options(Town::all()->pluck('name', 'id'))
                          ->searchable()->required(),
                      Forms\Components\TextInput::make('title'),
                      RichEditor::make('description')->required(),
                      Forms\Components\SpatieMediaLibraryFileUpload::make('thumbnail')->collection('property'),
                      Forms\Components\TextInput::make('contact')->required(),
                      Forms\Components\Toggle::make('is_available')->required()
                  ]
              )

            ]);
    }
//php artisan make:filament-relation-manager TownResourse Property title
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
                Tables\Columns\TextColumn::make('id'),
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('town.name'),
                Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\SpatieMediaLibraryImageColumn::make('thumbnail')->collection('property'),
                Tables\Columns\TextColumn::make('contact'),
               Tables\Columns\BooleanColumn::make('is_available'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListProperties::route('/'),
            'create' => Pages\CreateProperty::route('/create'),
            'edit' => Pages\EditProperty::route('/{record}/edit'),
        ];
    }
}
