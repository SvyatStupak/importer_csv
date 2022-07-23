<?php

class Controller {

    private $fields;
    private $objIm;

    public function __construct()
    {
        require_once 'config.php';

        $this->fields = $fields;
        $this->objIm = new CsvImporter('users-1.csv', FALSE, ',');
    }
     
    public function render() 
    {

        if(isset($_POST['fields'])) {
            $result = $this->objIm->get(); 
            $db = new MyDB();
            $db->store($result, $_POST['fields']);
            header('Location: index.php');
        }

        $result = $this->objIm->get();
        echo $this->getContent('index', ['result' => $result, 'fields' => $this->fields]);
    }
    
    /**
     * getContent - шаблонизатор
     *
     * @param  mixed $vars - массив переменных которые будуд передаватся в шаблон
     * @param  mixed $file - файл для подключения
     * @return void
     */
    public function getContent($file, $vars = [] ) 
    {
        ob_start();
        extract($vars);

        $pathToTemplate = 'templates/' . $file . '.php'; 
        if (file_exists($pathToTemplate)) 
            require_once $pathToTemplate;
        else 
            throw new \Exception('Path not found ' . $pathToTemplate);
        

        return ob_get_clean();
    }
}