<?php
class ActivitiesController extends AppController{
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') 
        {
            return true;
        }
    
       // Default deny
       return false;
    }
    
    public function index()
    {
        $this->autoRender = false;
    }
    
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
