<?php

namespace Informatec\Auth;

use Informatec\Models\User;

class Auth
{

    public function user()
    {
        if ($this->check())
            return User::where('email', $_SESSION['user'])->first();
        return null;
    }

    public function check()
    {
        return isset($_SESSION['user']);
    }

    public function attempt($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->password)) {
            $_SESSION['user'] = $user->email;
            return true;
        }
        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}
