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
    
    public function save($training_id)
    {
        
    }
    
    public function payment($record_id)
    {
        
    }

}

?>
