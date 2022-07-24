<?php

class Controller
{

    private $objImporter;
    private $objDB;

    public function __construct()
    {
        require_once 'config.php';
        $this->objImporter = new CsvImporter();
        $this->objDB = new MyDB();
    }

    public function render()
    {
        $db = $this->objDB;
        if (isset($_POST['Delete'])) {
            $db->delete();
        }

        if (isset($_POST['Export'])) {
            $db->export();
        }

        $result = $this->objImporter->get();
        if ($result) {
            $columnNameInFile = $result[0];
            
            $columnsNameInBD = $db->getNameColumns();
            if (count($columnNameInFile) == count($columnsNameInBD) and is_array($columnNameInFile) and is_array($columnsNameInBD)) {
                for ($i = 0; $i < count($columnsNameInBD); $i++) {
                    if ($columnsNameInBD[$i] !== $columnNameInFile[$i]) {
                        // throw new \Exception("Сheck the structure of the imported file");
                        echo "<script type=\"text/javascript\">
                        alert(\"Сheck the structure of the imported file\");
                        window.location = \"index.php\"
                        </script>";
                    }
                }
                $db->store($result, $columnsNameInBD);
                // header('Location: index.php');
            } else {
                echo "<script type=\"text/javascript\">
                        alert(\"Сheck the structure of the imported file\");
                        window.location = \"index.php\"
                        </script>";
                
            }
            echo $this->getContent();
        }
        echo $this->getContent();
    }

    /**
     * getContent - шаблонизатор
     *
     * @param  mixed $vars - массив переменных которые будуд передаватся в шаблон
     * @param  mixed $file - файл для подключения
     * @return void
     */
    public function getContent($vars = [])
    {
        ob_start();
        extract($vars);

        $url = $_SERVER['REQUEST_URI'];
        if ($url === "/" || $url === '/index.php') {
            require_once 'templates/index.php';
        } else if ($url == '/show.php' || $url == '/show.php/') {
            require_once 'templates/show.php';
        } else {
            throw new \Exception('Path not found ' . $_SERVER['REQUEST_URI']);
        }
        
        return ob_get_clean();

    }

}
