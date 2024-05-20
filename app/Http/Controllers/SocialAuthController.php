<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SocialAuthController extends Controller
{
    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function callback($provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->user();

            $user = User::where($provider . '_id', $providerUser->getId())->first();

            if (!$user) {
                // El usuario no existe, intenta encontrarlo por el correo electrónico
                $user = User::where('email', $providerUser->getEmail())->first();

                if (!$user) {
                    // El usuario no existe, crea uno nuevo
                    $newUser = User::create([
                        'name' => $providerUser->getName(),
                        'email' => $providerUser->getEmail(),
                        'password' => bcrypt(Str::random(16)),
                        $provider . '_id' => $providerUser->getId(),
                        'username' => $providerUser->getName(),
                    ]);

                    Auth::login($newUser, true);
                    return redirect()->intended('dashboard');
                } else {
                    // Asocia la cuenta del proveedor con el usuario existente
                    $user->update([$provider . '_id' => $providerUser->getId()]);
                    Auth::login($user, true);
                    return redirect()->intended('dashboard');
                }
            } else {
                Auth::login($user, true);
                return redirect()->intended('dashboard');
            }
        } catch (\Throwable $th) {
            Log::error('Something went wrong: ' . $th->getMessage()); // Aquí se utiliza la clase Log correctamente
            // Puedes manejar la excepción de manera más adecuada, como redirigir al usuario a una página de error
        }
    }
}
