<?php

namespace App\Http\Controllers\Auth;

use App\Domains\User\Contracts\Request\LoginRequest;
use App\Domains\User\Contracts\UserServiceInterface;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    private $_userServiceInterface;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @param UserServiceInterface $userServiceInterface
     */
    public function __construct(UserServiceInterface $userServiceInterface)
    {
        $this->middleware('guest')->except('logout');

        $this->_userServiceInterface = $userServiceInterface;
    }

    public function login(Request $request)
    {
        $loginRequest = new LoginRequest();

        $loginRequest->email = $request->input('email');
        $loginRequest->password = $request->input('password');

        $this->validateLogin($request);

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        $responseLogin = $this->_userServiceInterface->loginToApiDocument($loginRequest);

        if (!$responseLogin->isSuccess()) {
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    protected function attemptLogin(Request $request)
    {
        $request->merge(['is_active' => 1]);

        return $this->guard()->attempt(
            $this->credentials($request), $request->filled('remember')
        );
    }

    protected function credentials(Request $request)
    {
        return $request->only($this->username(), 'password', 'is_active');
    }
}
