<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PositionsController
 *
 * @author awojtys
 */
class ProfessionsController extends AppController{
    /**
     * 
     * @param type $user User role
     * @return boolean return logged or unlogged
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
     * 
     * @param int $id Profession id
     * @return JSON Return data of selected profession
     */
    public function view($id)
    {
        $this->autoRender = false;
        $profession = $this->Profession->findById($id);
        $data['id'] = $profession['Profession']['id'];
        $data['name'] = $profession['Profession']['name'];
        return json_encode($data);
    }
    
    /**
     * Method for display all of professions
     * 
     * @return JSON Display all of professions
     */
    public function index()
    {
        $this->autoRender = false;
        $professions = $this->Profession->find('all');
        if($professions != null)
        {
            foreach ($professions as $key => $profession)
            {
                $data[$key]['id'] = $profession['Profession']['id'];
                $data[$key]['name'] = $profession['Profession']['name'];
            }
            return json_encode($data);
        }
        else
        {
            return json_encode(true);
        }
    }
    
    /**
     * Method for edit selected profession
     * 
     * @param int $id Profession id
     * @return JSON Return if edit is successful
     */
    public function edit($id)
    {
        $this->autoRender = false;
        $profession = $this->Profession->findById($id);
        
        $this->Profession->id = $id;
        if($this->Profession->save($this->request->data)){
            return json_encode(true);
        }
        else{
            exit;
        }
        
        if (!$this->request->data) {
            $this->request->data = $profession;
        }
    }
    
    /**
     * Method to delete profession
     * 
     * @param int $id Profession id
     * @return JSON Return if delete is successful
     */
    public function delete($id)
    {
        $this->autoRender = false;
        if($this->Profession->delete($id))
        {
            return json_encode(true);
        }
        else
        {
            exit;
        }
    }
    
    /**
     * Method add new profession to database
     * 
     * @return JSON Return if edit is successful
     */
    public function add()
    {
        $this->autoRender = false;
        $this->Profession->create();
        if($this->Profession->save($this->request->data))
        {
            return json_encode(true);
        }
        else
        {
            exit;
        }
    }
}
?>
