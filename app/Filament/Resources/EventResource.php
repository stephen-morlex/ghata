<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Filament\Resources\EventResource\RelationManagers;
use App\Models\Category;
use App\Models\Event;
use App\Models\Location;
use App\Models\User;
use Closure;
use Filament\Forms;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Event Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug'),
                Forms\Components\DatePicker::make('start_date')->displayFormat('d/m/Y'),
                Forms\Components\DatePicker::make('end_date')->displayFormat('d/m/Y'),
                Forms\Components\TimePicker::make('start_time'),
                Forms\Components\TimePicker::make('end_time'),
                Forms\Components\Select::make('location_id')->label('Location')
                    ->options(Location::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('category_id')->label('Category')
                    ->options(Category::all()->pluck('name', 'id'))
                    ->searchable(),
                Forms\Components\Select::make('user_id')->label('Creator')
                    ->options(User::all()->pluck('name', 'id'))
                    ->searchable(),
                SpatieMediaLibraryFileUpload::make('cover')->collection('events/covers')->minSize(512)
                    ->maxSize(2048),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                SpatieMediaLibraryImageColumn::make('image')->collection('events/covers')->rounded()->size(50),
                Tables\Columns\TextColumn::make('name')->label('Title'),
                // Tables\Columns\TextColumn::make('description'),
                TextColumn::make('user.name')->label('Creator'),
                Tables\Columns\TextColumn::make('start_date')
                    ->date(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date(),
                Tables\Columns\TextColumn::make('start_time'),
                Tables\Columns\TextColumn::make('end_time'),
                TextColumn::make('category.name'),
                TextColumn::make('location.name'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime(),
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
            'index' => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit' => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
