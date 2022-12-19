<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PersonalInformationRuleSeeder::class);
        $this->call(EmploymentDetailsRuleSeeder::class);
        $this->call(LoanDetailsRuleSeeder::class);
        $this->call(BeneficiariesRuleSeeder::class);
        $this->call(ReferencesRuleSeeder::class);
    }
}
