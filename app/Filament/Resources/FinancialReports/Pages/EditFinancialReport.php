<?php
namespace App\Filament\Resources\FinancialReports\Pages;
use App\Filament\Resources\FinancialReports\FinancialReportResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Auth;
class EditFinancialReport extends EditRecord {
     protected static string $resource = FinancialReportResource::class;
     protected function mutateFormDataBeforeSave(array $data): array { $data['updated_by'] = Auth::id(); return $data; }

     protected function getRedirectUrl(): string
     {
         return static::getResource()::getUrl('view', ['record' => $this->getRecord()]);
     }
}
