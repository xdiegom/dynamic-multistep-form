<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BeneficiariesRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $beneficiaries = DB::table('input_fields_validations')->insertGetId([
            'input_name' => 'beneficiaries',
            'parent_input_id' => null,
            'request_key' => 'beneficiaries',
            'rules' => 'required|array|min:2'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'beneficiaries.*.name',
            'parent_input_id' => $beneficiaries,
            'request_key' => 'beneficiaries',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'beneficiaries.*.relationship',
            'parent_input_id' => $beneficiaries,
            'request_key' => 'beneficiaries',
            'rules' => 'required'
        ]);
    }
}
