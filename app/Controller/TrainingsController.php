<?php

class TrainingsController extends AppController { 
    public $uses = array('Training', 'Activities');
    
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
        return json_encode(true);
    }
    
    /**
     * Method to add new training to database
     */
    public function add()
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
    
}

?>
