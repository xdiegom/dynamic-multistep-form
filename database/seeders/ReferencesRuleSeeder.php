<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ReferencesRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $references = DB::table('input_fields_validations')->insertGetId([
            'input_name' => 'references',
            'parent_input_id' => null,
            'request_key' => 'references',
            'rules' => 'required|array|min:2'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'references.*.name',
            'parent_input_id' => $references,
            'request_key' => 'references',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'references.*.relationship',
            'parent_input_id' => $references,
            'request_key' => 'references',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'references.*.company_name',
            'parent_input_id' => $references,
            'request_key' => 'references',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'references.*.phone_number',
            'parent_input_id' => $references,
            'request_key' => 'references',
            'rules' => 'required|size:8'
        ]);
    }
}
