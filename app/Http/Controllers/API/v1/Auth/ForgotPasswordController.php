<?php

namespace App\Http\Controllers\API\v1\Auth;

use App\Core\Services\Response\BasicResponse;
use App\Http\Controllers\BaseController;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    use BaseController, SendsPasswordResetEmails;


    //<editor-fold desc="#public (method)">

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $response = new BasicResponse();

        if (filter_var($request->input('identity'), FILTER_VALIDATE_EMAIL)) {
            $identity = [
                'email' => $request->input('identity')
            ];
        } else {
            $identity = [
                'username' => $request->input('identity')
            ];
        }

        $this->validateEmail($request);

        $result = $this->broker()->sendResetLink($identity);

        if ($result == Password::RESET_LINK_SENT) {
            $response->addSuccessMessageResponse($response->getMessageCollection(), 'Email reset was sent. Please check your email', 200);
        } else {
            $response->addErrorMessageResponse($response->getMessageCollection(), 'Email was not available', 401);
        }

        if (!$response->isSuccess()) {
            return $this->getBasicErrorJson($response);
        }

        return $this->getBasicSuccessJson($response);
    }

    //</editor-fold>


    //<editor-fold desc="#protected (method)">

    /**
     * @param Request $request
     */
    protected function validateEmail(Request $request)
    {
        if (filter_var($request->input('identity'), FILTER_VALIDATE_EMAIL)) {
            $this->validate($request, ['identity' => 'required|email']);
        }
    }

    //</editor-fold>
}
