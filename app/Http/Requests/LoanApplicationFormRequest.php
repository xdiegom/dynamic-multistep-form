<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Http\FormRequest;

class LoanApplicationFormRequest extends FormRequest
{
    /**
     * Rules that will be apply to the request
     * @var array
     */
    protected $rules = [];

    /**
     * Rules that will be apply to the request
     * @var \Illuminate\Support\Collection
     */
    protected $dataRules;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return $this->rules;
    }

    /**
    * Prepare the data for validation.
    *
    * @return void
    */
    protected function prepareForValidation()
    {
        $requestKeys = array_keys($this->all());
        $this->dataRules = DB::table('input_fields_validations')->get();

        $this->mapDataRules();
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $validator->errors()->addIf(
                empty($this->rules),
                'invalid_request_keys',
                'no valid request keys provided in request'
            );
        });
    }

    /**
     * Map data rules to locales and rules to be
     * applied in the corresponding format
     * @return void
     */
    protected function mapDataRules()
    {
        $this->rules = $this->dataRules->flatMap(
            fn ($rule) =>[$rule->input_name => explode('|', $rule->rules) ]
        )->toArray();
    }
}
