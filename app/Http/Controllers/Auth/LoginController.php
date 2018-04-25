<?php

namespace Filebrowser\Http\Controllers\Auth;

use Filebrowser\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Laravel\Socialite\Facades\Socialite;
use Filebrowser\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Redirect;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback()
    {
      try{
        $user = Socialite::driver('google')->stateless()->user();
        //Check if the user has domain set in his account
        if(isset($user->user['domain'])){
          $userDomain = $user->user['domain'];
          // Check if that domain is same that has been set .env file
          if($userDomain == env('DOMAIN')){

            // If yes then insert new user into database with received information
            $authUser = $this->createUser($user);

            // Auth the login
            Auth::login($authUser, true);
            // Return user to root
            return redirect('/');
              //return $user->token;
          }
        }
        else{
          // If user has not domain or the domain is not the same as in .env file then don't allow user to login.
          dd("Shame on you!");
        }
      }
      catch(Exeption $e){
        return redirect('auth/google');
      }

    }

    // Create new user with received information
    public function createUser($user){
      $authUser = User::where('google_id', $user->id)->first();
      if($authUser){
        return $authUser;
      }
      return User::create([
          'name' => $user->name,
          'email' => $user->email,
          'password' => bcrypt('1q2w3e4r'),
          'user_privileges' => 1,
          'user_upload_privilege' => 1,
          'google_id' => $user->id,
      ]);
    }
}
