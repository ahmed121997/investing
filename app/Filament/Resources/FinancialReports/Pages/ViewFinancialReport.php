<?php
namespace App\Filament\Resources\FinancialReports\Pages;
use App\Filament\Resources\FinancialReports\FinancialReportResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
class ViewFinancialReport extends ViewRecord { protected static string $resource = FinancialReportResource::class; protected string $view = 'filament.resources.financial-reports.pages.view-financial-report'; protected function getHeaderActions(): array { return [EditAction::make()]; } }
