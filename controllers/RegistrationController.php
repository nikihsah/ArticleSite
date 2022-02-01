<?php

declare(strict_types=1);

include(ROOT . '/Components/BD.php');

class RegistrationController
{

    public function actionIndex(){

        if ($_POST){

            $result = $this->validation();

            if ($result != false){
                $_POST['455'] = $result;
            }else{
                $BD = new BD();
                $BD ->addUser($_POST['username'], $_POST['password'], $_POST['email']);
            }
        }

        include_once(ROOT . '/view/includes/header.php');
        include_once(ROOT . '/view/registration.php');
        include_once(ROOT . '/view/includes/footer.php');

        return True;
    }

    /**
     * @return Exception|false
     */
    private function validation(){

        $BD = new BD();
        $users = $BD->getByColumn('users', 'username', 'hashpassword', 'email');

        $error = false;
        try{
            foreach ($users as $key => $user){

                $this->usernameCorrect($user);
                $this->emailCorrect($user);
                $this->passwordCorrect($user);

            }
        }catch (Exception $e){
            $error = $e;
        }

        return $error;
    }

    /**
     * @param array $user
     *
     * @throws Exception
     */
    private function usernameCorrect(array $user)
    {
        if ($user['username'] == $_POST['username']){
            throw new Exception('Данное имя пользователя уже используется');
        }
        if (!(strlen($_POST['username']) > 6)){
            throw new Exception('Имя пользователя должно содержать больше 6 символов');
        }
    }

    /**
     * @param array $user
     *
     * @throws Exception
     */
    private function emailCorrect(array $user)
    {
        if ($user['email'] == $_POST['email']) {
            throw new Exception('Данная почта уже используется');
        }
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
            throw new Exception('Почта записана некоректно');
        }
    }

    /**
     * @param array $user
     *
     * @throws Exception
     */
    private function passwordCorrect(array $user)
    {
        if(!preg_match('#^\S*(?=\S{8,25})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#', $_POST['password'])){
            throw new Exception('Пароль должен содержать не менее 8 символов, иметь прописные и заглавные буквы');
        }
    }
}