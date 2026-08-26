<?php

namespace App\Filament\Resources\WalletLogs\Pages;

use App\Filament\Resources\WalletLogs\WalletLogResource;
use Filament\Resources\Pages\ListRecords;

class ListWalletLogs extends ListRecords
{
    protected static string $resource = WalletLogResource::class;
}
