<?php
class Controller_Authorization extends Controller {
    public function __construct() {
        $this->model = new Model_Authorization($_POST);
        $this->view = new View();
    }

    public function action_index() {
        if (empty($_POST)) {
            $message = 'Enter your login and password:';
        } elseif (empty($_POST['login']) or empty($_POST['password'])) {
            $message = 'Enter your login/password/email';
        }else {
            $values = $this->model->search_user_in_DB();
            if (empty($values)) {
                $message = 'Invalid login or password';
            } else {
                setcookie("DBV[d]", $values->id, time() + 72000, '/');
                $host = $_SERVER['REQUEST_SCHEME'] . '://' .$_SERVER['HTTP_HOST'].'/';
                header('Location:'.$host.'apache_log');
            }
        }
        $this->view->generate('authorization_view.php', 'template_view.php', $message);
    }
}
