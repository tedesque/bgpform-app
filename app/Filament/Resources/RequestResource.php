<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\bgpRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RequestResource extends Resource
{
    protected static ?string $model = bgpRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('circuit_id')
                    ->required()
                    ->label('Designador'),
                Forms\Components\TextInput::make('circuit_speed')
                    ->required()
                    ->numeric()
                    ->label('Velocidade'),
                Forms\Components\TextInput::make('token')
                    ->default(strval(Str::uuid()))
                    ->label('Token')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('circuit_id')->label('Designador do circuito'),
                Tables\Columns\TextColumn::make('circuit_speed')->label('Velocidade'),
                Tables\Columns\TextColumn::make('request_status')->badge()->color(fn (string $state): string => match ($state) {
                    'Pendente' => 'warning',
                    'Concluído' => 'success',
                    'Rejeitado' => 'danger',
                }),
                Tables\Columns\TextColumn::make('token')->label('Token'),
                Tables\Columns\TextColumn::make('created_at')->label('Data criação'),
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
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
            'assign' => Pages\ClientAssign::route('/assign/{record}'),
        ];
    }
}
