<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SignupController extends Controller
{
    public function add(Request $request)
    {
        var_dump($request->post()); die;
    }
}
