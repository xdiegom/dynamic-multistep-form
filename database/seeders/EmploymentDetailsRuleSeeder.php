<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EmploymentDetailsRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $employmentDetails = DB::table('input_fields_validations')->insertGetId([
            'input_name' => 'employment_details',
            'parent_input_id' => null,
            'request_key' => 'employment_details',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'employment_details.source_of_income',
            'parent_input_id' => $employmentDetails,
            'request_key' => 'employment_details',
            'rules' => 'required|in:employed,self-employed,other'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'employment_details.job_title',
            'parent_input_id' => $employmentDetails,
            'request_key' => 'employment_details',
            'rules' => 'required|string'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'employment_details.company_name',
            'parent_input_id' => $employmentDetails,
            'request_key' => 'employment_details',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'employment_details.company_address',
            'parent_input_id' => $employmentDetails,
            'request_key' => 'employment_details',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'employment_details.monthly_gross',
            'parent_input_id' => $employmentDetails,
            'request_key' => 'employment_details',
            'rules' => 'required|numeric'
        ]);
    }
}
