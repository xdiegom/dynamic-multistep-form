<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LoanDetailsRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $loanDetails = DB::table('input_fields_validations')->insertGetId([
            'input_name' => 'loan_details',
            'parent_input_id' => null,
            'request_key' => 'loan_details',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'loan_details.requested_loan_amount',
            'parent_input_id' => $loanDetails,
            'request_key' => 'loan_details',
            'rules' => 'required|numeric|min:10000'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'loan_details.loan_term',
            'parent_input_id' => $loanDetails,
            'request_key' => 'loan_details',
            'rules' => 'required|numeric|in:1,3,5,7,9,10'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'loan_details.purpose_of_the_loan',
            'parent_input_id' => $loanDetails,
            'request_key' => 'loan_details',
            'rules' => 'required|in:purchase,refinance,debt-consolidation,education-related-expenses'
        ]);
    }
}
