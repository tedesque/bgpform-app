<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RequestResource\Pages;
use App\Filament\Resources\RequestResource\RelationManagers;
use App\Models\BgpRequest;
use Filament\Forms;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\TextEntry;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class RequestResource extends Resource
{
    protected static ?string $model = BgpRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function infolist(Infolist $infolist): Infolist
    {
    return $infolist
        ->schema([
            Infolists\Components\TextEntry::make('token'),
            Infolists\Components\TextEntry::make('asn'),
            Infolists\Components\TextEntry::make('circuit_id')
                ->columnSpanFull(),
        ]);
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('token')
                    ->default(strval(Str::uuid()))
                    ->label('Token')
                    ->readonly(),
                Forms\Components\TextInput::make('circuit_id')
                    ->required()
                    ->label('Designador'),
                Forms\Components\TextInput::make('circuit_speed')
                    ->required()
                    ->numeric()
                    ->label('Velocidade'),
                // Forms\Components\TextInput::make('asn')
                //     ->label('ASN')
                //     ->maxLength(30)
                //     ->visible(fn ($record) => $record !== null),
                Forms\Components\TextInput::make('router_table')
                    ->label('Tabela de roteamento solicitada')
                    ->maxLength(100)
                    ->readonly()
                    ->visible(fn ($record) => $record !== null),
                // Forms\Components\TextInput::make('as_set')
                //     ->label('AS-SET')
                //     ->maxLength(30)
                //     ->visible(fn ($record) => $record !== null),
                // Forms\Components\TextInput::make('tech_name1')
                //     ->label('Responsável técnico')
                //     ->columnSpan('half')
                //     ->visible(fn ($record) => $record !== null),
                Forms\Components\Select::make('request_status')
                    ->options([
                        'Concluida' => 'Concluída',
                        'Pendente' => 'Pendente',
                        'Rejeitada' => 'Rejeitada',
                    ])->default('Pendente')
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
                    'Concluida' => 'success',
                    'Rejeitada' => 'danger',
                }),
                // Tables\Columns\TextColumn::make('asn')->label('ASN'),
                Tables\Columns\TextColumn::make('token')->label('Token')
                    ->copyable()
                    ->copyMessage('Copiado!')
                    ->copyMessageDuration(1500),
                Tables\Columns\TextColumn::make('created_at')->label('Data criação'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            // RelationManagers\PrefixRelationManager::class,
            RelationManagers\AsnEntitiesRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRequests::route('/'),
            'create' => Pages\CreateRequest::route('/create'),
            'view' => Pages\ViewBgpEntry::route('{record}'),
            'edit' => Pages\EditRequest::route('/{record}/edit'),
        ];
    }
}
