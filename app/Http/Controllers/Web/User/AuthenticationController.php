<?php

namespace App\Http\Controllers\Web\User;

use App\Core\Controller;
use App\Http\Requests\Web\User\AuthenticationController\OAuthRequest;
use App\Interfaces\Eloquent\IPasswordResetService;
use App\Interfaces\Eloquent\IPersonalAccessTokenService;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    private $personelAccessTokenService;

    public function __construct(IPersonalAccessTokenService $personalAccessTokenService)
    {
        $this->personelAccessTokenService = $personalAccessTokenService;
    }

    public function login()
    {
        if (auth()->guard('user_web')->check()) {
            return redirect()->route('user.web.dashboard.index');
        }

        return view('user.modules.authentication.login.index');
    }

    public function oAuth(OAuthRequest $request)
    {
        $token = $this->personelAccessTokenService->findToken($request->token);
        if ($token->isSuccess()) {
            if (!$employee = $token->getData()->tokenable) {
                return redirect()->route('user.web.authentication.login.index');
            }

            session()->put('_token', $token->getData()->token);
            session()->put('_user_id', $employee->id);
            session()->put('_user_name', $employee->name);
            session()->put('_user_email', $employee->email);
            auth()->guard('user_web')->login($employee, $request->remember);

            return redirect()->route('user.web.dashboard.index');
        } else {
            return redirect()->route('user.web.authentication.login.index');
        }
    }

    public function forgotPassword()
    {
        return view('user.modules.authentication.forgotPassword.index');
    }

    public function resetPassword(Request $request, IPasswordResetService $passwordResetService)
    {
        if (!$request->token) {
            abort(404);
        }

        $passwordReset = $passwordResetService->getByToken($request->token);

        if (!$passwordReset->getData() || $passwordReset->getData()->used == 1) {
            abort(404);
        }

        if ($passwordReset->getData()->created_at->addMinutes(60)->isPast()) {
            abort(404);
        }

        return view('user.modules.authentication.resetPassword.index', [
            'token' => $request->token
        ]);
    }

    public function logout()
    {
        auth()->guard('user_web')->logout();
        return redirect()->route('user.web.authentication.login.index');
    }
}
