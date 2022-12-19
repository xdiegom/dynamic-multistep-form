<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PersonalInformationRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $personalInformationId = DB::table('input_fields_validations')->insertGetId([
            'input_name' => 'personal_information',
            'parent_input_id' => null,
            'request_key' => 'personal_information',
            'rules' => 'required'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.first_name',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|string'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.last_name',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|string'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.date_of_birth',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|date'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.status',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|in:single,married,separated,divorced,widowed'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.spouse_name',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required_if:personal_information.status,married|string|nullable'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.email',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|email'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.phone_number',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|size:8'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.current_address',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|string'
        ]);

        DB::table('input_fields_validations')->insert([
            'input_name' => 'personal_information.city',
            'parent_input_id' => $personalInformationId,
            'request_key' => 'personal_information',
            'rules' => 'required|string'
        ]);
    }
}
