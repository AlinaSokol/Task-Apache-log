<?php
require_once 'model_authorization.php';
class Model_Apache_log extends Model_Authorization {
    const FILENAME = "D:\OSPanel\userdata\logs\Apache_2.4-PHP_7.2-7.4_errora.log";
    const TABLE_HEAD = ['date', 'ssl', 'pid', 'error'];
    private $list;

    public function get_data_from_logfile() {
        $this->transform_data_from_logfile();
        return json_encode($this->list);
    }
    private function open_file () {
        $fd = fopen (self::FILENAME, 'r');
        while (!feof($fd)) {
            $this->list[] = fgets($fd);
        }
        fclose($fd);
    }
    private function transform_data_from_logfile() {
        $this->open_file();
        for ($i = 0; $i < count($this->list); $i++) {
            $this->list[$i] = explode('] [', $this->list[$i]);
            for ($j = 0; $j < count($this->list[$i]); $j++) {
                if (self::TABLE_HEAD[$j] === 'date') {
                    $this->list[$i][self::TABLE_HEAD[$j]] = trim($this->list[$i][$j], '[');
                } elseif (self::TABLE_HEAD[$j] === 'pid') {
                    $pid = explode('] ', $this->list[$i][$j]);
                    unset($this->list[$i][$j]);
                    $this->list[$i][self::TABLE_HEAD[$j]] = $pid[0];
                    $this->list[$i][self::TABLE_HEAD[++$j]] = $pid[1];
                }
                else {
                    $this->list[$i][self::TABLE_HEAD[$j]] = $this->list[$i][$j];
                }
                unset($this->list[$i][$j]);
            }
        }
        return $this->list;
    }
}
