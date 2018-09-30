<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\Frontend\Auth\UserLoggedOut;
use App\Http\Requests\Api\Auth\ResendVerificationCodeRequest;
use App\Http\Requests\Api\Auth\UpdateNonVerifyMobileRequest;
use App\Http\Requests\Api\Auth\UserLoginRequest;
use App\Http\Requests\Api\Auth\UserMobileVerificationRequest;
use App\Models\Access\User\User;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Validator;

/**
 * @resource Auth
 *
 * All auth related functions
 */
class AuthController extends APIController
{
    /**
     * Log the user in.
     * mobile:3234225990
     * password:1234
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(UserLoginRequest $request)
    {
        $credentials = $request->only(['mobile', 'password']);

        try {
            if (!$token = JWTAuth::attempt($credentials)) {
                return $this->throwValidation(trans('api.messages.login.failed'));
            }
        } catch (JWTException $e) {
            return $this->respondInternalError($e->getMessage());
        }

        if (!empty($request->get('fcm_token'))) {
            $deviceToken = [
                'fcm_token' => $request->get('fcm_token'),
            ];
            $deviceInfo = [
                'type' => $request->get('device_type'),
                'agent_info' => $request->get('agent_info'),
                'device_id' => $request->device_id
            ];
            User::find(\Auth::id())->devices()->updateOrCreate($deviceToken, $deviceInfo);
        }

        return $this->respond([
            'message_title' => "Success",
            'message' => trans('api.messages.login.success'),
            'token' => $token,
            'status_code' => 200,
            'success' => true,
            'user' => \Auth::user()
        ]);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            $token = JWTAuth::getToken();

            if ($token) {
                JWTAuth::invalidate($token);
            }
        } catch (JWTException $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'message' => trans('api.messages.logout.success'),
        ]);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            $this->respondUnauthorized(trans('api.messages.refresh.token.not_provided'));
        }

        try {
            $refreshedToken = JWTAuth::refresh($token);
        } catch (JWTException $e) {
            return $this->respondInternalError($e->getMessage());
        }

        return $this->respond([
            'status' => trans('api.messages.refresh.status'),
            'token' => $refreshedToken,
        ]);
    }

    /**
     * Verify mobile number.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function verifyMobile(UserMobileVerificationRequest $request)
    {
        $dbConfirmationCode = \Auth::user()->confirmation_code;
        //if (\Hash::check($dbConfirmationCode, $request->get('confirmation_code'))) {
        $user = User::find(\Auth::id());
        $user->confirmed = 1;
        $user->save();
        return $this->respond([
            'message_title' => "Success",
            'message' => 'Thakn you for your mobile confirmation',
            'status_code' => 200,
            'success' => true,
            'user' => \Auth::user()
        ]);
        //}
        return apiErrorRes(402, 'Verification code is wrong.');
    }

    /**
     * Update non verfied mobile number
     */
    public function updateNonVerifiedNum(UpdateNonVerifyMobileRequest $request)
    {
        $isUserConfirmed = (boolean)\Auth::user()->confirmed;
        if (!$isUserConfirmed) {
            $user = User::find(\Auth::id());
            $user->mobile = $request->mobile;
            $user->save();
            return $this->respond([
                'message_title' => "Success",
                'message' => 'Phone number updated.',
                'status_code' => 200,
                'success' => true,
                'user' => \Auth::user()
            ]);
        }

        return apiErrorRes(402, 'Phone already verified.');
    }

    /**
     * Resend verification code
     * @param ResendVerificationCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function resendVerificationCode(ResendVerificationCodeRequest $request)
    {
        $user = User::find(\Auth::id());
        $user->confirmation_code = bcrypt(1234);
        $user->save();
        return $this->respond([
            'message_title' => "Success",
            'message' => 'Verification code resend, for now its 1234.',
            'status_code' => 200,
            'success' => true,
            'user' => \Auth::user()
        ]);
    }
}
