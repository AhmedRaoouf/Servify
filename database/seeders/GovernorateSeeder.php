<?php

namespace Database\Seeders;

use App\Models\Governorate;
use App\Models\GovernorateDescription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GovernorateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $governorates = [
            ['name_en' => 'Alexandria', 'name_ar' => 'الإسكندرية', 'country_id' => 1],
            ['name_en' => 'Aswan', 'name_ar' => 'أسوان', 'country_id' => 1],
            ['name_en' => 'Asyut', 'name_ar' => 'أسيوط', 'country_id' => 1],
            ['name_en' => 'Beheira', 'name_ar' => 'البحيرة', 'country_id' => 1],
            ['name_en' => 'Beni Suef', 'name_ar' => 'بني سويف', 'country_id' => 1],
            ['name_en' => 'Cairo', 'name_ar' => 'القاهرة', 'country_id' => 1],
            ['name_en' => 'Dakahlia', 'name_ar' => 'الدقهلية', 'country_id' => 1],
            ['name_en' => 'Damietta', 'name_ar' => 'دمياط', 'country_id' => 1],
            ['name_en' => 'Faiyum', 'name_ar' => 'الفيوم', 'country_id' => 1],
            ['name_en' => 'Gharbia', 'name_ar' => 'الغربية', 'country_id' => 1],
            ['name_en' => 'Giza', 'name_ar' => 'الجيزة', 'country_id' => 1],
            ['name_en' => 'Ismailia', 'name_ar' => 'الإسماعيلية', 'country_id' => 1],
            ['name_en' => 'Kafr El Sheikh', 'name_ar' => 'كفر الشيخ', 'country_id' => 1],
            ['name_en' => 'Luxor', 'name_ar' => 'الأقصر', 'country_id' => 1],
            ['name_en' => 'Matrouh', 'name_ar' => 'مطروح', 'country_id' => 1],
            ['name_en' => 'Minya', 'name_ar' => 'المنيا', 'country_id' => 1],
            ['name_en' => 'Monufia', 'name_ar' => 'المنوفية', 'country_id' => 1],
            ['name_en' => 'New Valley', 'name_ar' => 'الوادي الجديد', 'country_id' => 1],
            ['name_en' => 'North Sinai', 'name_ar' => 'شمال سيناء', 'country_id' => 1],
            ['name_en' => 'Port Said', 'name_ar' => 'بورسعيد', 'country_id' => 1],
            ['name_en' => 'Qalyubia', 'name_ar' => 'القليوبية', 'country_id' => 1],
            ['name_en' => 'Qena', 'name_ar' => 'قنا', 'country_id' => 1],
            ['name_en' => 'Red Sea', 'name_ar' => 'البحر الأحمر', 'country_id' => 1],
            ['name_en' => 'Sharqia', 'name_ar' => 'الشرقية', 'country_id' => 1],
            ['name_en' => 'Sohag', 'name_ar' => 'سوهاج', 'country_id' => 1],
            ['name_en' => 'South Sinai', 'name_ar' => 'جنوب سيناء', 'country_id' => 1],
            ['name_en' => 'Suez', 'name_ar' => 'السويس', 'country_id' => 1],
        ];

        foreach ($governorates as $id => $governorate) {
            $newGovernorate = Governorate::create(['id' => $id+1]);
            GovernorateDescription::create([
                'governorate_id' => $newGovernorate->id,
                'name' => $governorate['name_en'],
                'language_id' => 1, // English language_id
                'country_id' => $governorate['country_id']
            ]);
            GovernorateDescription::create([
                'governorate_id' => $newGovernorate->id,
                'name' => $governorate['name_ar'],
                'language_id' => 2, // Arabic language_id
            ]);
        }

    }
}
