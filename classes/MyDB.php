<?php

class MyDB
{
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

    public function getNameColumns()
    {
        try {
            $query = "SHOW COLUMNS FROM users";
            $result = $this->db->query($query);
            if (!$result) {
                throw new Exception("ERROR: " . $this->db->errno . '|' . $this->db->error);
            }

            $resultNameColumns = [];
            while ($row = mysqli_fetch_array($result)) {
                $resultNameColumns[] = $row['Field'];
            }
            return $resultNameColumns;
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
    }

    public function store($csv, $fieldsInBD)
    {
        if (PASS_FIRST) array_shift($csv);
        $columns = '';
        foreach ($fieldsInBD as $key => $files) {
            $columns .= '`' . $files . '`' . ',';
        }
        $columns = trim($columns, ',');
        if ($columns) {
            $str = '';
            foreach ($csv as $item) {
                $r = '';
                foreach ($item  as $key => $value) {
                    $r .= "'" . $this->db->real_escape_string($value) . "',";
                }
                $r = trim($r, ',');
                if ($r) {
                    $str .= '(' . $r . '),';
                }
            }
            $str = trim($str, ',');



            try {
                $query = "REPLACE INTO `users` (" . $columns . ") VALUES " . $str;
                $result = $this->db->query($query);
                if (!$result) {
                    throw new Exception("ERROR: " . $this->db->errno . '|' . $this->db->error);
                }
                echo "<script type=\"text/javascript\">
                        alert(\"CSV File has been successfully Imported.\");
                        window.location = \"index.php\"
                      </script>";
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function export()
    {
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=data.csv');
        $output = fopen("php://output", "w");
        $nameColumns = $this->getNameColumns();
        fputcsv($output, $nameColumns);
        $query = "SELECT * from `users`";
        $result = $this->db->query($query);
        while ($row = mysqli_fetch_assoc($result)) {
            fputcsv($output, $row);
        }
        fclose($output);
        exit();
    }

    public function delete()
    {
        $query = "DELETE FROM `users`";
        $result = $this->db->query($query);
        if (!$result) {
            throw new Exception("ERROR: " . $this->db->errno . '|' . $this->db->error);
        }
        echo "<script type=\"text/javascript\">
                        alert(\"Data from the database has been deleted.\");
                        window.location = \"index.php\"
                      </script>";
    }
}
