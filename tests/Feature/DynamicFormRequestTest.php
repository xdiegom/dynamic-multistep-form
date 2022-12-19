<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DynamicFormRequestTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    /** @test */
    public function it_passes_object_group_validation()
    {
        $this->postJson('/api/loan-application/validate', [
            'personal_information' => [
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'date_of_birth' => '1992-09-12',
                'status' => 'single',
                'email' => $this->faker->email,
                'phone_number' => $this->faker->randomNumber(8, true),
                'current_address' => $this->faker->address,
                'city' => $this->faker->city
            ]
        ])->assertStatus(Response::HTTP_ACCEPTED);
    }

    /** @test */
    public function it_passes_array_group_validation()
    {
        $this->postJson('/api/loan-application/validate', [
            'references' => [
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word,
                    'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8, true)
                ],
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word,
                    'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8, true)
                ]
            ]
        ])->assertStatus(Response::HTTP_ACCEPTED);
    }

    /** @test */
    public function it_throw_validation_errors_in_object_group_validation()
    {
        $this->postJson('/api/loan-application/validate', [
            'personal_information' => [
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'date_of_birth' => '1992-09-12',
                'status' => 'married',
                'email' => $this->faker->email,
                'phone_number' => $this->faker->randomNumber(8, true),
                'current_address' => $this->faker->address,
                'city' => $this->faker->city
            ]
        ])->assertJsonValidationErrors(['personal_information.spouse_name']);
    }

    /** @test */
    public function it_throw_validation_errors_in_array_group_validation()
    {
        $this->postJson('/api/loan-application/validate', [
            'references' => [
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word,
                    'phone_number' => $this->faker->randomNumber(8, true)
                ],
                [
                    'name' => $this->faker->name,
                    'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8, true)
                ]
            ]
        ])->assertJsonValidationErrors(['references.0.company_name', 'references.1.relationship']);
    }

    /** @test */
    public function it_throw_errors_no_request_keys_if_no_required_key_is_provided_to_form_validation()
    {
        $this->postJson('/api/loan-application/validate', [])
             ->assertJsonValidationErrors([
                'invalid_request_keys'
             ]);
    }

    /** @test */
    public function it_throw_errors_validations_for_all_required_fields_on_submition()
    {
        $this->postJson('/api/loan-application', [])
             ->assertJsonValidationErrors([
                'personal_information',
                'references',
                'loan_details',
                'employment_details',
                'beneficiaries'
             ]);
    }

    /** @test */
    public function it_passes_validations_for_all_required_fields_on_submition()
    {
        $sourceOfIncomes = ['employed', 'self-employed', 'other'];
        $terms = [1, 3, 5 ,7 ,9, 10];
        $statuses = ['single', 'married', 'separated', 'divorced', 'widowed'];
        $loanPurposes = ['purchase','refinance','debt-consolidation','education-related-expenses'];

        $this->postJson('/api/loan-application', [
            'personal_information' => [
                'first_name' => $this->faker->firstName,
                'last_name' => $this->faker->lastName,
                'date_of_birth' => '1992-09-12',
                'status' => $status = $statuses[array_rand($statuses)],
                'spouse_name' => $status == 'married' ? $this->faker->name : null,
                'email' => $this->faker->email,
                'phone_number' => $this->faker->randomNumber(8, true),
                'current_address' => $this->faker->address,
                'city' => $this->faker->city
            ],
            'references' => [
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word,
                    'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8, true)
                ],
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word,
                    'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8, true)
                ]
            ],
            'beneficiaries' => [
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word
                ],
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word
                ]
            ],
            'loan_details' => [
                'requested_loan_amount' => $this->faker->numberBetween(10000, 30000),
                'loan_term' => $terms[array_rand($terms)],
                'purpose_of_the_loan' => $loanPurposes[array_rand($loanPurposes)]
            ],
            'employment_details' => [
                'source_of_income' => $sourceOfIncomes[array_rand($sourceOfIncomes)],
                'job_title' => $this->faker->jobTitle,
                'company_name' => $this->faker->company,
                'company_address' => $this->faker->address,
                'monthly_gross' => $this->faker->numberBetween(5000, 10000)
            ]
        ])->assertOk();
    }
}
