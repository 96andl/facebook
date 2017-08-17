<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use GuzzleHttp\Psr7\Response;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';
    private $user;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $user)
    {
        $this->user = $user;
        $this->middleware('guest')->except('logout');
    }
    /**
     * Redirect the user to the Facebook authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
       return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        if($request->get('error') === "access_denied" and $request->headers) {
            dd("You denies permission to your facebook profile.");
        }
        $user = Socialite::driver('facebook')->user();
//        print_r($user);

        $userIsCreate = $this->user->findOrCreateSocialUser('facebook', $user->id, $user);
        if($userIsCreate) {
            session()->put('user_name',$user->name);
        }
        if(!session()->exists('access_token')) {
            if($request->code) {

                $url = "https://graph.facebook.com/v2.10/oauth/access_token?client_id=".config('services.facebook.client_id').
                    "&redirect_uri=".config('services.facebook.redirect')."&client_secret=".config('services.facebook.client_secret')."&code=$request->code";
                $ch = curl_init();

                curl_setopt($ch, CURLOPT_URL,$url);
                curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

                $st = curl_exec($ch);
                session()->put("access_token",json_decode($st)->access_token);


            }
        }
        return redirect()->route('facebook-posts');
    }
}
