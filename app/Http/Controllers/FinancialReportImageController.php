<?php

namespace App\Http\Controllers;

use App\Models\FinancialReport;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\File;
use Spatie\Browsershot\Browsershot;

class FinancialReportImageController extends Controller
{
    public function __invoke(FinancialReport $financialReport): Response
    {
        $financialReport->loadMissing('stock.sector');

        $theme = request()->query('theme') === 'dark' ? 'dark' : 'light';
        $chromeDataPath = storage_path('app/browsershot');

        File::ensureDirectoryExists($chromeDataPath);
        File::ensureDirectoryExists("{$chromeDataPath}/data");
        File::ensureDirectoryExists("{$chromeDataPath}/config");
        File::ensureDirectoryExists("{$chromeDataPath}/cache");

        $image = Browsershot::html(view('financial-reports.image', [
            'report' => $financialReport,
            'theme' => $theme,
        ])->render())
            ->setNodeBinary('/usr/bin/node')
            ->setNodeModulePath(base_path('node_modules'))
            ->setChromePath('/usr/bin/google-chrome')
            ->setNodeEnv([
                'XDG_DATA_HOME' => "{$chromeDataPath}/data",
                'XDG_CONFIG_HOME' => "{$chromeDataPath}/config",
                'XDG_CACHE_HOME' => "{$chromeDataPath}/cache",
            ])
            ->setUserDataDir("{$chromeDataPath}/profile")
            ->noSandbox()
            ->windowSize(1600, 1000)
            ->deviceScaleFactor(2)
            ->fullPage()
            ->screenshot();

        $filename = 'financial-report-'.str($financialReport->stock?->code ?? $financialReport->id)->slug().'.png';

        return response($image, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
