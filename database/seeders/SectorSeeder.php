<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    public function run(): void
    {
        $sectors = [
            ['name' => 'Banks', 'name_ar' => 'بنوك'],
            ['name' => 'Basic Resources', 'name_ar' => 'موارد أساسية'],
            ['name' => 'Healthcare & Pharmaceuticals', 'name_ar' => 'رعاية صحية و ادوية'],
            ['name' => 'Industrial Products & Services & Automobiles', 'name_ar' => 'خدمات و منتجات صناعية وسيارات'],
            ['name' => 'Real Estate', 'name_ar' => 'عقارات'],
            ['name' => 'Tourism & Recreation', 'name_ar' => 'سياحة وترفيه'],
            ['name' => 'Utilities', 'name_ar' => 'مرافق'],
            ['name' => 'Telecommunications & Media & IT', 'name_ar' => 'اتصالات و اعلام و تكنولوجيا المعلومات'],
            ['name' => 'Food, Beverages & Tobacco', 'name_ar' => 'أغذية و مشروبات و تبغ'],
            ['name' => 'Energy & Support Services', 'name_ar' => 'طاقة وخدمات مساندة'],
            ['name' => 'Trade & Distribution', 'name_ar' => 'تجارة و موزعون'],
            ['name' => 'Transportation & Shipping Services', 'name_ar' => 'خدمات النقل والشحن'],
            ['name' => 'Educational Services', 'name_ar' => 'خدمات تعليمية'],
            ['name' => 'Non-Banking Financial Services', 'name_ar' => 'خدمات مالية غير مصرفية'],
            ['name' => 'Contracting & Engineering Construction', 'name_ar' => 'مقاولات و إنشاءات هندسية'],
            ['name' => 'Textiles & Durable Goods', 'name_ar' => 'منسوجات و سلع معمرة'],
            ['name' => 'Building Materials', 'name_ar' => 'مواد البناء'],
            ['name' => 'Paper, Packaging & Wrapping Materials', 'name_ar' => 'ورق ومواد تعبئة و تغليف'],
        ];

        foreach ($sectors as $sector) {
            Sector::firstOrCreate($sector);
        }
    }
}
