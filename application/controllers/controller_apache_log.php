<?php
class Controller_Apache_log extends Controller
{
    public function __construct() {
        $this->model = new Model_Apache_log();
        $this->view = new View();
    }
    public function action_index() {
        $authorization = $this->model->check_authorization();
        if ($authorization) {
            $message = $this->model->get_data_from_logfile();
            $this->view->generate('apache_log_view.php', 'template_view.php', $message);
        } else {
            Route::ErrorPage404();
        }
    }
}
