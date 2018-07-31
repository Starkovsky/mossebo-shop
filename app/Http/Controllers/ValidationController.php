<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Checkout\EmailRequest;
use App\Http\Requests\Checkout\PhoneRequest;

class ValidationController extends Controller
{
    public function email(EmailRequest $request)
    {
        return response(null, 200);
    }

    public function phone(PhoneRequest $request)
    {
        return response(null, 200);
    }
}
