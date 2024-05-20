<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;

class GithubAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('github')->redirect();
    }
    public function callbackgithub()
    {
        try {
            $github_user = Socialite::driver('github')->user();
            $user = User::where('github_id', $github_user->getId())->first();

            if (!$user) {
                // El usuario no existe, intenta encontrarlo por el correo electrónico
                $user = User::where('email', $github_user->getEmail())->first();

                $name = $github_user->getName();

                // Verificar si el nombre está disponible
                if (empty($name)) {
                    // Manejar el caso donde el nombre no está disponible
                    $name = 'Usuario';
                }

                if (!$user) {
                    // El usuario no existe, crea uno nuevo
                    $new_user = User::create([
                        'name' => $name,
                        'email' => $github_user->getEmail(),
                        'password' => bcrypt(Str::random(16)),
                        'github_id' => $github_user->getId(),
                        'username' => $github_user->getNickname(),
                    ]);

                    Auth::login($new_user, true);

                    return redirect()->intended('dashboard');
                } else {
                    // Asocia la cuenta de GitHub con el usuario existente
                    $user->update(['github_id' => $github_user->getId(), 'name' => $name]);

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
