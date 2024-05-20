<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;


class GoolgleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    public function callbackgoogle()
    {
        try {
            $google_user = Socialite::driver('google')->user();
            $user = User::where('google_id', $google_user->getId())->first();

            if (!$user) {
                // El usuario no existe, intenta encontrarlo por el correo electrónico
                $user = User::where('email', $google_user->getEmail())->first();

                if (!$user) {
                    // El usuario no existe, crea uno nuevo
                    $new_user = User::create([
                        'name' => $google_user->getName(),
                        'email' => $google_user->getEmail(),
                        'password' => bcrypt(Str::random(16)),
                        'google_id' => $google_user->getId(),
                        'username' => $google_user->getName(),
                    ]);

                    Auth::login($new_user, true);

                    return redirect()->intended('dashboard');
                } else {
                    // Asocia la cuenta de Google con el usuario existente
                    $user->update(['google_id' => $google_user->getId()]);

                    Auth::login($user, true);

                    return redirect()->intended('dashboard');
                }
            } else {
                Auth::login($user, true);

                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            dd('Something went wrong!' . $th->getMessage());
        }
    }
}
