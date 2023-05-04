<?php
class Model_Authorization extends Model {
    protected $conn;
    protected $data;
    protected $user;
    protected $userdata;

    public function __construct($arrayPost = null) {
        $connection = new Connection();
        $this->conn = $connection->getConnection();
        $this->data = $arrayPost;
        $this->user = $_COOKIE['DBV']['d'];
    }
    public function search_user_in_DB() {
        $stmt = "SELECT `id` FROM `users` WHERE (`login` = :login AND `pass` = :pass)";
        $query_stmt = $this->conn->prepare($stmt);
        $query_stmt->execute(['login' => $this->data['login'], 'pass' => hash('md5', $this->data['password'])]);
        return $query_stmt->fetch(PDO::FETCH_OBJ);
    }
    public function check_authorization() {
        $this->userdata = $this->select_userdata_in_DB();
        if ($this->userdata->count == 0) {
            $host = $_SERVER['REQUEST_SCHEME'] . '://' .$_SERVER['HTTP_HOST'].'/';
            header('Location:'.$host.'apache_log');
        } else {
            return true;
        }
    }
    protected function select_userdata_in_DB() {
        $query = "SELECT COUNT(*) AS 'count' FROM `users` WHERE (`id` = :id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam('id', $this->user, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_OBJ);
    }
}
