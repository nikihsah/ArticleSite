<?php

declare(strict_types=1);

namespace controllers;

use components\BD;
use components\ValidateException;

class RegistrationController
{

    public function actionIndex(){

        if ($_POST){

            $result = $this->validation();

            if ($result != false){
                $_POST['455'] = true;
            }else{
                $BD = new BD();
                $BD ->addUser($_POST['username'], $_POST['password'], $_POST['email']);
            }
        }

        $this->render();

        return True;
    }

    private function render()
    {
        include_once(ROOT . '/view/includes/header.php');
        include_once(ROOT . '/view/registration.php');
        include_once(ROOT . '/view/includes/footer.php');
    }

    /**
     * @return false
     */
    private function validation(): bool
    {

        $BD = new BD();
        $users = $BD->getByColumn('users', 'username', 'hashpassword', 'email');

        $error = false;
        try{
            foreach ($users as $key => $user){

                $this->usernameCorrect($user);
                $this->emailCorrect($user);
                $this->passwordCorrect();

            }
        }catch (ValidateException $e){
            $error = $e->getMessage();
        }

        return $error;
    }

    /**
     * @param array $user
     *
     * @throws ValidateException
     */
    private function usernameCorrect(array $user)
    {
        if ($user['username'] == $_POST['username']){
            throw new ValidateException('Данное имя пользователя уже используется');
        }
        if (!(strlen($_POST['username']) > 6)){
            throw new ValidateException('Имя пользователя должно содержать больше 6 символов');
        }
    }

    /**
     * @param array $user
     *
     * @throws ValidateException
     */
    private function emailCorrect(array $user)
    {
        if ($user['email'] == $_POST['email']) {
            throw new ValidateException('Данная почта уже используется');
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            throw new ValidateException('Почта записана некоректно');
        }
    }

    /**
     * @throws ValidateException
     */
    private function passwordCorrect()
    {
        if(!preg_match('#^\S*(?=\S{8,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#', $_POST['password'])){
            throw new ValidateException('Пароль должен содержать не менее 8 символов, иметь прописные и заглавные буквы');
        }
    }
}