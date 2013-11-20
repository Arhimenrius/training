<?php

App::uses('TrainingHelper', 'Lib');
class TrainingsController extends AppController { 
    public $uses = array('Training', 'Activity');
    
    /**
     * Method for authorization
     * 
     * @param type $user
     * @return boolean Display logged or unlogged
     */
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') 
        {
            return true;
        }
    
       // Default deny
       return false;
    }
    public function beforeFilter() 
    {
        parent::beforeFilter();
        $this->Auth->allow(array('index', 'view'));
    }
    
    /**
     * Default page
     */
    public function viewall()
    {
        
    }
    
    /**
     * Method return all of trainings
     * 
     * @return JSON Return all trainings
     */
    public function index()
    {
        $this->autoRender = false;
        $trainings = $this->Training->find('all');
        if($trainings != null)
        {
            foreach($trainings as $key => $value)
            {
                $data[$key] = $value['Training'];
                $data[$key]['Activity'] = $value['Activity'];
            }
            return json_encode($data);
        }
        else
        {
            exit;
        }
    }
    
    /**
     * Method to add new training to database
     */
    public function add()
    {
        $this->autoRender = false;
        $this->Training->create();
        $prepare = new TrainingHelper($this->request->data);
        $data = $prepare->returnNew();
        if($this->Training->saveAll($data)){
            
            return json_encode($this->Training->id);
        }
        else{
            exit;
        }
    }
    
    public function view($id)
    {
        $this->autoRender = false;
        $training = $this->Training->findById($id);
        if($training != null)
        {
            $data['id'] = $training['Training']['id'];
            $data['name'] = $training['Training']['name'];
            $data['start_date'] = $training['Training']['start_date'];
            $data['active'] = $training['Training']['active'];
            $data['activity'] = $training['Activity'];
            return json_encode($data);
        }
        else
        {
            exit;
        }
    }
    
    public function edit($id)
    {
        $this->autoRender = false;
        if(array_key_exists('training_name', $this->request->data))
        {
            $training = $this->Training->findById($id);
            $prepare = new TrainingHelper($this->request->data);
            $data = $prepare->returnArray();
            if($this->Training->saveAll($data)){
                return json_encode(true);
            }
            else{
                exit;
            }
        }
        else {
            if($this->Training->save($this->request->data)){
                   return json_encode(true);
            }
            else{
                exit;
            }
        }
        
        if (!$this->request->data) {
            $this->request->data = $training;
        }
    }
    
    public function delete($id)
    {
        $this->autoRender = false;
        if($this->Training->delete($id, true))
        {
            return json_encode(true);
        }
        else
        {
            return json_encode(false);
        }
    }
    
}

?>
