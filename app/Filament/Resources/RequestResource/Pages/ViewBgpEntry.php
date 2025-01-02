<?php

namespace App\Filament\Resources\RequestResource\Pages;

use App\Filament\Resources\RequestResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components\Section;



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
                Infolists\Components\Section::make('Informação de contato')
                    ->schema([
                        Infolists\Components\TextEntry::make('circuit_id')
                            ->label('Designador do circuito'),
                        Infolists\Components\TextEntry::make('tech_name1')
                            ->label('Responsável Técnico:'),
                        Infolists\Components\TextEntry::make('tech_mail1')
                            ->label('Email:')
                            ->icon('heroicon-m-envelope'),
                        Infolists\Components\TextEntry::make('tech_phone1')
                            ->label('Telefone:')
                            ->icon('heroicon-m-phone'),
                    ])->columns(2)
                    ->compact(),

                    Infolists\Components\Section::make('ASN')
                    ->schema([
                        Infolists\Components\TextEntry::make('asn')->weight('bold'),
                        Infolists\Components\TextEntry::make('token')
                            ->copyable()
                            ->columnSpan(2),
                        Infolists\Components\TextEntry::make('request_status')
                            ->label('Estado da requisição')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'Pendente' => 'warning',
                                'Concluida' => 'success',
                                'Rejeitado' => 'danger',
                            })
                            ->extraAttributes(['class' => 'font-bold']),

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
                        Infolists\Components\TextEntry::make('as_set')
                            ->label('AS-SET'),
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
