<?php

namespace MyProject\Controllers;

use MyProject\Exceptions\InvalidArgumentException;
use MyProject\Models\Users\User;
use MyProject\Models\Users\UserActivationService;
use MyProject\Models\Users\UsersAuthService;
use MyProject\Services\EmailSender;
use MyProject\Controllers\AbstractController;
use MyProject\Exceptions\ActivateUserExeption;

class UsersController extends AbstractController
{
    public function signUp()
    {
        if (!empty($_POST)) {           
            try {
                $user = User::signUp($_POST);
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/signUp.php', ['error' => $e->getMessage()]);
                return;
            }

            if ($user instanceof User) {
                $code = UserActivationService::createActivationCode($user);

                EmailSender::send($user, 'Активация', 'userActivation.php', [
                    'userId' => $user->getId(),
                    'code' => $code
                ]);

                $this->view->renderHtml('users/signUpSuccessful.php');
                return;
            }
        }
        $this->view->renderHtml('users/signUp.php');
    }
    
    public function activate(int $userId, string $activationCode)
    {
        try {
            $user = User::getById($userId);

            if ($user === null) {
                throw new ActivateUserExeption('Нет такого пользователя');
            }

            if ($user->getIsConfirmed() === 1) {
                throw new ActivateUserExeption('Пользователь уже активирован');
            }

            $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);

            if (!$isCodeValid) {
                throw new ActivateUserExeption('Не создан код активации');
            }

            if ($isCodeValid) {
                $user->activate();
                UserActivationService::deleteActivationCode($user);
                $this->view->renderHtml('mail/activationSuccessful.php', []);
            }

        } catch (ActivateUserExeption $e) {
            $this->view->renderHtml('errors/noId.php', ['error' => $e->getMessage()]);
            return;
        }

        $user = User::getById($userId);
        $isCodeValid = UserActivationService::checkActivationCode($user, $activationCode);

        if ($isCodeValid) {
            $user->activate();
            $this->view->renderHtml('mail/activationSuccessful.php', []);
        }
    }

    public function login()
    {
        if (!empty($_POST)) {
            try {
                $user = User::login($_POST);
                UsersAuthService::createToken($user);
                header('Location: /');
                exit();
            } catch (InvalidArgumentException $e) {
                $this->view->renderHtml('users/login.php', ['error' => $e->getMessage()]);
                return;
            }
        }
        $this->view->renderHtml('users/login.php');
    }

    public function logout()
    {
        UsersAuthService::deleteToken();
        header('Location: /');
    }
}