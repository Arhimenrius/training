<?php

class RecordsController extends AppController{
    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    public function viewall()
    {
        
    }
    
    public function index()
    {
        $this->autoRender = false;
    }
    
    public function view($id)
    {
        $this->autoRender = false;
    }
    
    public function edit($id)
    {
        $this->autoRender = false;
    }
    
    public function delete($id)
    {
        $this->autoRender = false;
    }
    
    public function add()
    {
        $this->autoRender = false;
    }

}

?>
