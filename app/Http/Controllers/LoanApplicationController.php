<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\LoanApplicationFormRequest;

class LoanApplicationController extends Controller
{
    public function __invoke(LoanApplicationFormRequest $request)
    {
        // LOGIC ABOUT SUBMITTING A LOAN APPLICATION
        return response()->json(null, Response::HTTP_OK);
    }
}
