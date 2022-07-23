<?php 

class MyDB {
    protected $db;

    public function __construct()
    {
        $this->db = new mysqli(HOST, USER, PASSWORD, DB); 
        if ($this->db->connect_error) {
            throw new \Exception('Connection error: ' . $this->db->connect_error);
        }
    }

    public function __destruct()
    {  
        if ($this->db) {
            $this->db->close();
        }
    }

    public function store($csv, $fields)
    {
        if (PASS_FIRST) array_shift($csv);
        $columns = '';
        $ignore = [];

        foreach ($fields as $key => $filed) {
            if($filed == 'no') {
                $ignore[] = $key;
                continue;
            }
            
            $columns .= '`' . $filed . '`' . ',';
        }
        $columns = trim($columns, ',');
        if($columns) {
            $str = '';

            foreach ($csv as $item) {
                $r = '';
                foreach ($item  as $key => $value) {
                    if(is_array($ignore) && in_array($key, $ignore)) {
                        continue;
                    }
                    $r .= "'" . $this->db->real_escape_string($value) . "',";
                }
                $r = trim($r, ',');
                if ($r) {
                    $str .= '(' . $r . '),';
                }
            }
            $str = trim($str, ',');

            try {
                $query = "INSERT INTO `users` (" . $columns . ") VALUES " . $str; 
                $result = $this->db->query($query);
                
                if(!$result) {
                    throw new Exception("ERROR: " . $this->db->errno.'|'. $this->db->error);
                    
                }
                
            } catch (\Exception $e) {
                echo $e->getMessage();
                exit();
            }
        }
    }
}