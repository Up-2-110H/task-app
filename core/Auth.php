<?php


namespace core;


use models\User;

class Auth
{
    /**
     * @var null|User
     */
    private $_user = null;

    public function can($controller, $action)
    {

        /** @var array $access */
        $access = call_user_func([$controller, 'access']);

        if (isset($access[$action])) {
            switch ($access[$action]) {
                case '?':
                    return !$this->isAuth();
                case '@':
                    return $this->isAuth();
                case '$':
                    return $this->isAdmin();
            }
        }

        return true;
    }

    public function isAuth()
    {
        return $this->_user !== null;
    }

    public function isAdmin()
    {
        return $this->isAuth() && $this->_user->status == 0;
    }

    public function login($username, $password)
    {
        $username = strtolower($username);

        $user = User::findByUsername($username);

        if ($user && $user->checkPassword($password)) {
            setcookie('id', $user->id, time() + (86400 * 30), '/');
            setcookie('key', $this->getKey($user), time() + (86400 * 30), '/');

            $this->_user = $user;

            return true;
        }

        return false;
    }

    public function logout()
    {
        setcookie('id', '', time() - 3600, '/');
        setcookie('key', '', time() - 3600, '/');
        $this->_user = null;
    }

    public function checkAuth()
    {
        $id = isset($_COOKIE['id']) ? $_COOKIE['id'] : null;
        $key = isset($_COOKIE['key']) ? $_COOKIE['key'] : null;

        if ($id && $key) {

            $user = User::findOne(['id' => $id]);

            if ($user && $this->checkKey($user, $key)) {
                $this->_user = $user;
            }
        }
    }

    public function getUser()
    {
        return $this->_user;
    }

    private function getKey(User $user)
    {
        return password_hash($user->id . $user->username, PASSWORD_DEFAULT);
    }

    private function checkKey(User $user, $key)
    {
        return password_verify($user->id . $user->username, $key);
    }
}