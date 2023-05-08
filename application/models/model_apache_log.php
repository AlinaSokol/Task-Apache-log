<?php
require_once 'model_authorization.php';
class Model_Apache_log extends Model_Authorization {
    const TABLE_HEAD = ['date', 'php7', 'pid', 'server', 'error'];
    private $list;
    private $output_list;

    public function get_data_from_logfile() {
        $filename = $_SERVER['DOCUMENT_ROOT'] . "/error.log (1).2";
        $fd = fopen ($filename, 'r');
        while (!feof($fd)) {
            $this->list[] = fgets($fd);
        }
        fclose($fd);
        foreach ($this->list as $index => $row) {
            if (strpos($row, 'PHP Warning') !== false) {
                continue;
                //$this->output_list[] = $row;
            } else {
                $row = explode('] [', $this->list[$index]);
                foreach ($row as $key => $item) {
                    if (self::TABLE_HEAD[$key] === 'date') {
                        $this->output_list[$index][$key] = trim($item, '[');
                        //$this->list[$i][self::TABLE_HEAD[$j]] = trim($this->list[$i][$j], '[');
                    } elseif (self::TABLE_HEAD[$key] === 'server') {
                        $pid = explode('] ', $item);
                        $this->output_list[$index][$key] = $pid[0];
                        $this->output_list[$index][$key] = $pid[1];
                    } else {
                        //$this->list[$i][self::TABLE_HEAD[$j]] = $this->list[$i][$j];
                        $this->output_list[$index][$key] = $item;
                    }
                }
            }
        }
        return json_encode($this->output_list);
    }
}
