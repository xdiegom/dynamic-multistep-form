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
                'phone_number' => $this->faker->randomNumber(8),
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
                    'phone_number' => $this->faker->randomNumber(8)
                ],
                [
                    'name' => $this->faker->name,
                    'relationship' =>  $this->faker->word,
                    'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8)
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
                    // 'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8)
                ],
                [
                    'name' => $this->faker->name,
                    // 'relationship' =>  $this->faker->word,
                    'company_name' => $this->faker->company,
                    'phone_number' => $this->faker->randomNumber(8)
                ]
            ]
        ])->assertJsonValidationErrors(['references.0.company_name', 'references.1.relationship']);
    }
}
