<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MaterialsController
 *
 * @author awojtys
 */
class MaterialsController extends AppController{
    public function isAuthorized($user) {
        // Admin can access every action
        if (isset($user['role']) && $user['role'] === 'admin') 
        {
            return true;
        }
    
       // Default deny
       return false;
    }
    public function viewall()
    {
        
    }
    
    public function index()
    {
        $this->autoRender = false;
        $materials = $this->Material->find('all');
        if($materials != null)
        {
            foreach ($materials as $key => $material)
            {
                $data[$key]['id'] = $material['Material']['id'];
                $data[$key]['name'] = $material['Material']['name'];
            }
            return json_encode($data);
        }
        else
        {
            exit;
        }
    }
    
    public function add()
    {
        $this->autoRender = false;
        $this->Material->create();
        if($this->Material->save($this->request->data))
        {
            return json_encode(true);
        }
        else
        {
            exit;
        }
    }
    
    public function edit($id)
    {
        $this->autoRender = false;
        $material = $this->Material->findById($id);
        
        if($this->Material->save($this->request->data)){
            return json_encode(true);
        }
        else{
            exit;
        }
        
        if (!$this->request->data) {
            $this->request->data = $material;
        }
    }
    
    public function delete($id)
    {
        $this->autoRender = false;
        if($this->Material->delete($id))
        {
            return json_encode(true);
        }
        else
        {
            exit;
        }
    }
    
    public function view($id)
    {
        $this->autoRender = false;
        $material = $this->Material->findById($id);
        $data['id'] = $material['Material']['id'];
        $data['name'] = $material['Material']['name'];
        return json_encode($data);
    }
}

?>
