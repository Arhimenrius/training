<?php

App::uses('RecordHelper', 'Lib');
class RecordsController extends AppController{
    public $uses = array('Material', 'Record', 'Profession');
    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow();
    }
    public function viewall()
    {
        $this->set('materials', $this->Material->find('all'));
        $this->set('professions', $this->Profession->find('all'));
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
        $record = new RecordHelper($this->request->data);
        $record -> returnData();
        $this->autoRender = false;
    }

}

?>
