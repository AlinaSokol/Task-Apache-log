<?php
require_once 'model_authorization.php';
class Model_Apache_log extends Model_Authorization {
    const TABLE_HEAD = ['date', 'php7', 'pid', 'server', 'error'];
    private $list;

    public function get_data_from_logfile() {
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/error.log (1).2";
        $fd = fopen ($filename, 'r');
        while (!feof($fd)) {
            $this->list[] = fgets($fd);
        }
        fclose($fd);

        for ($i = 0; $i < count($this->list); $i++) {
            $this->list[$i] = explode('] [', $this->list[$i]);
            if (strpos($this->list[$i][0], 'PHP Warning:')) {
                unset($this->list[$i]);
            } elseif ($this->list[$i][1] !== 'php7:error') {
                unset($this->list[$i]);
            } else {
                for ($j = 0; $j < count($this->list[$i]); $j++) {
                    if (self::TABLE_HEAD[$j] === 'date') {
                        $this->list[$i][self::TABLE_HEAD[$j]] = trim($this->list[$i][$j], '[');
                    } elseif (self::TABLE_HEAD[$j] === 'server') {
                        $pid = explode('] ', $this->list[$i][$j]);
                        unset($this->list[$i][$j]);
                        $this->list[$i][self::TABLE_HEAD[$j]] = $pid[0];
                        $this->list[$i][self::TABLE_HEAD[++$j]] = $pid[1];
                    } else {
                        $this->list[$i][self::TABLE_HEAD[$j]] = $this->list[$i][$j];
                    }
                    unset($this->list[$i][$j]);
                }
            }
        }
        return json_encode($this->list);
    }
}
