<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;

class OAuthLoginController extends LoginController
{
    /**
     * OAuthLoginController constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function login(Request $request)
    {
        $url = config('eeyes.account.url') . 'oauth/authorize?' . http_build_query([
            'client_id' => config('eeyes.account.app.id'),
            'redirect_uri' => route('callback'),
            'response_type' => 'code',
            'scope' => implode(' ', [
                'info-username.read',
                'info-name.read',
                'info-email.read'
            ])
        ]);

        return redirect($url);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback(Request $request)
    {
        if ($request->has('error')) {
            throw new UnauthorizedException("认证失败");
        }

        try {
            $client = new Client;

            /** @var string $response 换取Token */
            $response = $client->post(config('eeyes.account.url') . 'oauth/token', [
                'form_params' => [
                    'grant_type' => 'authorization_code',
                    'client_id' => config('eeyes.account.app.id'),
                    'client_secret' => config('eeyes.account.app.secret'),
                    'redirect_uri' => route('callback'),
                    'code' => $request->code,
                ],
            ]);

            /** @var array $data 将获取到的 Token 数据转换为数组 */
            $data = json_decode((string)$response->getBody(),true);

            /** @var string $response 通过 Token 获取用户详细信息 */
            $response = $client->get(config('eeyes.account.url') . 'api/user', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => $data['token_type'] . ' ' . $data['access_token'],
                ]
            ]);

            /** @var array $data 将获取到的用户数据转换为数组 */
            $data = json_decode((string)$response->getBody(),true);
            if (!$user = User::where('username', $data['username'])->first())
            {
                $user = User::create([
                    'name' => $data['name'],
                    'username' => $data['username'],
                    'email' => $data['email'],
		    'avatar' => 'avatars/default.jpg',
		    'role' => 'user',
                    'password' => '*',
                ]);
            }

            /** 登陆 */
            Auth::login($user);
            return redirect('/')->with('success', '登陆成功！');

        } catch (\Exception $e) {
            Log::error($e->getMessage(), $request->toArray());
            throw new UnauthorizedException("认证失败");
        }
    }

    /**
     * @param \Illuminate\Http\Request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Routing\Redirector
     */
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect(config('eeyes.account.url') . '/logout?url=' . urlencode(url('/')));
    }
}
