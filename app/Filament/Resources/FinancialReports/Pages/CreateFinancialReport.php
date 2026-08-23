<?php
namespace App\Filament\Resources\FinancialReports\Pages;
use App\Filament\Resources\FinancialReports\FinancialReportResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
class CreateFinancialReport extends CreateRecord { protected static string $resource = FinancialReportResource::class; protected function mutateFormDataBeforeCreate(array $data): array { $data['created_by'] = Auth::id(); $data['updated_by'] = Auth::id(); return $data; } }
