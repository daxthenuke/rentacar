<?php
class renderView
{
    private $data = array();
    private $renderLayout;
    private $dataView;

    public function __construct($layoutName, $viewName)
    {
        $layout = 'app/View/layout/'.$layoutName.'.phtml';
        $layout2 = '../app/View/layout/'.$layoutName.'.phtml';
        $view = 'app/View/'.$viewName.'.phtml';
        $view2 = '../app/View/'.$viewName.'.phtml';
        if (file_exists($layout)) {
            $this->renderLayout = $layout;
        }elseif (file_exists($layout2)){
            $this->renderLayout = $layout2;
        }
        else {
            throw new Exception('Layout ' . $layoutName . ' not found!');
            $this->render = false;
            exit();
        }
        if (file_exists($view)) {
            $this->dataView['view'] = $view;
        } elseif (file_exists($view2)){
            $this->dataView['view'] = $view2;
        }
        else {
            throw new Exception('View ' . $viewName . ' not found!');
            $this->renderView = false;
            exit();
        }
    }

//Foword variables to View
    public function assignVariable($variableName, $variableValue)
    {
        $this->data[$variableName] = $variableValue;
    }

    public function __destruct()
    {
        extract($this->data);
        extract($this->dataView);
        include($this->renderLayout);
    }
}
?>