<?php

class CsvImporter {

    // переменная для хранения дискриптор открытого CVS-файла
    private $fh;
    // перемення для хранения значение второго аргумента
    private $header;
    // перемення для хранения залоговка CVS-файла
    private $separator;
    // перемення для хранения значение третьего аргумента
    private $length;
    // переменная для хранения массива сформированого из первой строки импортируемого файла
    private $headerKeys;

        
    /**
     * __construct
     *
     * @param  mixed $fileName - имя файла который будет обрабатывать
     * @param  mixed $header - необходимость обработки строки заголовков
     * @param  mixed $separator - розделитель в импортируемой таблице
     * @param  mixed $length - допустимая длина строки в символах импортируемого файла,
     *               если значение меньше длины импортируемой строки, то импортируемые файлы будет розделенны на части длиной 
     *               указанным в параметре 
     * @return void
     */
    public function __construct($fileName, $header = false, $separator = ',', $length=8000)
    {
        $this->fh =fopen($fileName, 'r');
        $this->header = $header;
        $this->separator = $separator;
        $this->length = $length;

        // прочитываем первую строку импортируемого файла
        if ($this->header) {
            $this->headerKeys = fgetcsv($this->fh, $this->length);
        }

        

    }

    public function __destruct()
    {
        if ($this->fh) {
            fclose($this->fh);
        }
    }
    
    /**
     * get - метод возращает результат
     *
     * @param  mixed $max - указывает количество читаемых строк из CSV-файла, 0 - прочитать весь файл
     * @return void
     */
    public function get($max = 0) {
        $data = [];

        for ($line=0; $row = fgetcsv($this->fh, $this->length); $line++) { 
            if ($this->header) {
                foreach ($this->headerKeys as $key => $value) {
                    $row1[$value] = $row[$key];
                }
                $data[] = $row1;
            } else {
                $data[] = $row;
            }

            if ($max > 0) {
                if($max == $line) {
                    break;
                }
            }
        }

        return $data; 
    }

}