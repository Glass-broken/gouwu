<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_user extends CI_Controller {
    public function index() {
        $this->load->view('login/login');
    }

    public function validation() {
        $this->load->library('form_validation');
        $this->load->model('user');
        $this->load->model('admin');
        @$name = htmlentities($_REQUEST['username'], ENT_QUOTES, 'UTF-8');
        @$password = $_REQUEST['password'];
        $auto_login = $this->input->post('auto_login');
        $type = $this->input->post('type');
        @$code = $_REQUEST['validate_code'];
        $code = strtoupper($code);
        if ($code !== $_SESSION['validate_code']) {
            $_SESSION['error'] = '验证码错误';
            $this->load->view('login/login');
            return;
        }
        else {
            if ($type == 0) {
                $result = $this->user->is_user($name, $password);
                if (!empty($result)) {
                    $_SESSION['user_id'] = $result;
                    $_SESSION['user_name'] = $name;
                    if ($auto_login == 'on') {
                        setcookie('username_cookie', $name, time() + 2592000);
                        setcookie('password_cookie', $password, time() + 2592000);
                    }
                    redirect(site_url('Home/index'));
                }
                else {
                    $_SESSION['error'] = '账号或密码错误';
                    $this->load->view('login/login');
                    return;
                }
            } else {
                $result = $this->admin->is_admin($name, $password);
                if (!empty($result->id)) {
                    $_SESSION['admin_id'] = $result->id;
                    $_SESSION['admin_name'] = $result->name;
                    if ($auto_login == 'on') {
                        setcookie('username_cookie', $name, time() + 2592000);
                        setcookie('password_cookie', $password, time() + 2592000);
                    }
                    $this->load->view('home/home_admin');
                }
                else {
                    $_SESSION['error'] = '账号或密码错误';
                    $this->load->view('login/login');
                    return;
                }
            }
        }

    }
}