<?php

class CsvImporter
{
    // перемення для хранения значение второго аргумента
    private $header;
    // розделитель CVS-файла
    private $separator;
    // перемення для хранения значение третьего аргумента
    private $length;
    // переменная для хранения массива сформированого из первой строки импортируемого файла
    private $headerKeys;



    /**
     * __construct
     *
     * @param  mixed $header - необходимость обработки строки заголовков
     * @param  mixed $separator - розделитель в импортируемой таблице
     * @param  mixed $length - допустимая длина строки в символах импортируемого файла,
     *               если значение меньше длины импортируемой строки, то импортируемые файлы будет розделенны на части длиной 
     *               указанным в параметре 
     * @return void
     */
    public function __construct($header = false, $separator = ',', $length = 10000)
    {
        $this->header = $header;
        $this->separator = $separator;
        $this->length = $length;
    }


    /**
     * get - метод возращает массив значений в зависимости от значения $header
     *
     * @param  mixed $max - указывает количество читаемых строк из CSV-файла, 0 - прочитать весь файл
     * @return void
     */
    public function get($max = 0)
    {

        if (isset($_POST["Import"])) {

            $filename = $_FILES["file"]["tmp_name"];
            if ($_FILES["file"]["size"] > 0 AND $_FILES["file"]["size"] < 2000000) {
                $file = fopen($filename, "r");

                // прочитываем первую строку импортируемого файла (название стобцов)
                if ($this->header) {
                    $this->headerKeys = fgetcsv($file, $this->length);
                }

                $data = [];

                for ($line = 0; $row = fgetcsv($file, $this->length); $line++) {
                    // сохраняев в название столбца => значение
                    if ($this->header) {
                        foreach ($this->headerKeys as $key => $value) {
                            $row1[$value] = $row[$key];
                        }
                        $data[] = $row1;
                    } else {
                        // сохраняем в обычный массив
                        if(isset($row[0])) $data[] = $row;
                    }

                    
                    if ($max > 0) {
                        if ($max == $line) {
                            break;
                        }
                    }
                }

                fclose($file);
                return $data;

            } else {
                throw new \Exception("The file is empty or the size exceeds 2MB");
                
            }
        } 
    }
}
