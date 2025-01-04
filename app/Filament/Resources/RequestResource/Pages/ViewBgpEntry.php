<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use App\Models\AsnEntity;
use Blueprint\Builder;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;
use Illuminate\Support\Facades\DB;



class ViewBgpEntry extends ViewRecord
{
    protected static string $resource = RequestResource::class;

    public function getHeading(): string
    {
        return 'Detalhes da Requisição BGP';
    }

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informação da requisição')
                    ->schema([
                        Infolists\Components\TextEntry::make('circuit_id')
                            ->label('Designador do circuito'),
                        Infolists\Components\TextEntry::make('asnentities.tech_name')
                            ->label('Responsável Técnico:'),
                        Infolists\Components\TextEntry::make('asnentities.tech_mail')
                            ->label('Email:')
                            ->icon('heroicon-m-envelope'),
                        Infolists\Components\TextEntry::make('asnentities.tech_phone')
                            ->label('Telefone:')
                            ->icon('heroicon-m-phone'),
                    ])->columns(2)
                    ->compact(),

                Infolists\Components\Section::make('ASN')
                    ->schema([
                        Infolists\Components\TextEntry::make('request_status')
                            ->label('Estado da requisição')
                            ->badge()
                            ->color(fn(string $state): string => match ($state) {
                                'Pendente' => 'warning',
                                'Concluida' => 'success',
                                'Rejeitado' => 'danger',
                            })
                            ->extraAttributes(['class' => 'font-bold']),
                        Infolists\Components\TextEntry::make('token')
                            ->copyable()
                            ->columnSpan(2),
                        Infolists\Components\TextEntry::make('asnentities.asn')
                            ->label('AS_PATH'),
                        Infolists\Components\TextEntry::make('not_owner_as')
                            ->label('Anuncia ips alugados?  ')
                            ->formatStateUsing(function ($state) {
                                $map = [
                                    1 => 'Sim',
                                    0 => 'Não',
                                ];

                                return $map[$state] ?? 'Desconhecido';
                            }),
                        Infolists\Components\TextEntry::make('multihop')
                            ->formatStateUsing(function ($state) {
                                $map = [
                                    1 => 'Sim',
                                    0 => 'Não',
                                ];

                                return $map[$state] ?? 'Desconhecido';
                            }),
                        Infolists\Components\TextEntry::make('md5_session')
                            ->label('Senha da sessão')
                            ->icon('heroicon-m-key'),
                        Infolists\Components\TextEntry::make('Ola')
                            ->default(fn($record) => AsnEntity::query()->where('bgp_request_id', $record->id)->value('asn'))
                            ->label('AS Cliente'),
                    ])
                    ->compact()
                    ->columns(4)
            ]);
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
