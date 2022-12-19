<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoanApplicationValidationFormRequest;

class LoanApplicationFormValidationController extends Controller
{
    public function __invoke(LoanApplicationValidationFormRequest $request)
    {
        return response()->json(null, Response::HTTP_ACCEPTED);
    }
}
