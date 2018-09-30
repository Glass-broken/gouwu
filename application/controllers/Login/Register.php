<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
    public function index() {
        $this->load->view('login/register');
    }

    public function registers() {
        $this->load->model("user");

        $name = htmlentities($_REQUEST['username'], ENT_QUOTES, 'UTF-8');
        $password = $_REQUEST['password'];
        $rpassword = $_REQUEST['rpassword'];
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if($email === false) {
            $_SESSION['error'] = 'email address error';
            $this->load->view('login/register');
        }
        $sex = $_REQUEST['sex'];
        $phone = filter_input(INPUT_POST, 'phone', FILTER_VALIDATE_INT);
        if($phone === false || strlen($phone) != 11) {
            $_SESSION['error'] = 'phone must be numbers and available';
            $this->load->view('login/register');
        }
        $age = filter_input(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        if($age === false || $age < 0 || $age >120) {
            $_SESSION['error'] = 'age must be numbers and between 0 and 120';
            $this->load->view('login/register');
        }


        if ($password != $rpassword) {
            $_SESSION['error'] = '两次输入的密码不一致';
            $this->load->view('login/register');
        }

        $password_hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 12]);
        if($password_hash === false) {
            throw new Exception('password hash failed');
        }
        try {
            $flag = $this->user->add_user($name, $sex, $password_hash, $age, $phone, $email);
        } catch (Exception $e) {
            print $e->getMessage();

        }
        if ($flag) {
            $this->load->view('login/login');
        }else {
            $this->load->view('login/register');
        }
    }
}