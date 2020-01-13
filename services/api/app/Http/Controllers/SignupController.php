<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Message\MessagePayload;

class SignupController extends Controller
{
    public function add(Request $request)
    {
        try {
            $response = $this->messageBus->sync(
                'ns-signup',
                [
                    'role' => 'signup',
                    'cmd' => 'add',
                    'payload' => $request->post(),
                ]
            );

            return $this->buildResponse($response);
        } catch (\Exception $e) {
            // @todo Log this error
            return $this->apiResponse(['error' => 'An unknown error occurred'], 500);
        }
    }

    private function buildResponse(MessagePayload $payload): Response
    {
        if ($payload->get('success') === true) {
            return $this->apiResponse(['message' => 'Signup Added'], 201);
        }

        return $this->apiResponse(['error' => $payload->get('error')], (int)$payload->get('code'));
    }
}
