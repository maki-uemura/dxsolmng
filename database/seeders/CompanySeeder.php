<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SearchForm;
use App\Models\FormField;

class CompanySeeder extends Seeder
{
    public function run()
    {
        // Company A
        $companyA = SearchForm::create(['title' => 'A企業']);
        $companyA->formFields()->createMany([
            ['item_name' => '社員', 'value' => '佐藤'],
            ['item_name' => '社員', 'value' => '鈴木'],
            ['item_name' => '社員', 'value' => '田中'],
            ['item_name' => '企業口座', 'value' => 'UFJ 八王子支店 普通 000000000001 111'],
            ['item_name' => '契約開始日', 'value' => '2020年2月29日'],
        ]);

        // Company B
        $companyB = SearchForm::create(['title' => 'B企業']);
        $companyB->formFields()->createMany([
            ['item_name' => '社員', 'value' => '奈良'],
            ['item_name' => '社員', 'value' => '飛鳥'],
            ['item_name' => '社員', 'value' => '東大'],
            ['item_name' => '企業口座', 'value' => 'UFJ 日野支店 普通 000000000002 112'],
            ['item_name' => '契約開始日', 'value' => '2021年3月31日'],
        ]);
    }
}