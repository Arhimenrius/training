<?php

App::uses('RecordHelper', 'Lib');
class RecordsController extends AppController{
    public $uses = array('Material', 'Record', 'Profession', 'Payment', 'Student', 'Child');
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
        $record = $this->Record->findById($id);
        $material = $this->Material->find('all', array(
            'conditions' => array(
                "Material.id" => array($record['Application']['material_1_id'], $record['Application']['material_2_id'], $record['Application']['material_3_id'], $record['Application']['material_4_id'], $record['Application']['material_5_id'])
            )
        ));
        $record['Material'] = $material;
        return json_encode($record);
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
        $record = new RecordHelper($this->request->data);
        $validate = $record->validData();
        if($validate === true)
        {
            $record->prepareData();
            $information = $record->returnInformation();
            $application = $record->returnApplication();
            $payment = $record->returnPayment();
            $data = array('Information' => $information, 'Application' => $application, 'Payment' => $payment, 'training_id' => $this->request->data['training_id']);
            $this->Record->create();
            if($this->Record->saveAll($data))
            {   
                $students = $record->returnStudents($this->Record->id);
                $childs = $record->returnChilds($this->Record->id);
                $this->Student->create();
                if($this->Student->saveAll($students))
                {
                    if(!empty($childs))
                    {
                        $this->Child->create();
                        if($this->Child->saveAll($childs))
                        {
                            if($record->changeAvaibility() === true)
                            {
                                return json_encode($this->Record->id);
                            }
                            else
                            {
                                $this->response->statusCode(500);
                                $record->deleteRecord($this->Record->id);
                                return json_encode("We can't add your record to database. Try again.");
                            }
                        }
                        else
                        {
                            $this->response->statusCode(500);
                            $record->deleteRecord($this->Record->id);
                            return json_encode("We can't add your record to database. Try again.");
                        }
                    }
                    else 
                    {
                        if($record->changeAvaibility() === true)
                        {
                            return json_encode($this->Record->id);
                        }
                        else
                        {
                            $this->response->statusCode(500);
                            $record->deleteRecord($this->Record->id);
                            return json_encode("We can't add your record to database. Try again.");
                        }
                    }
                }
            }
            else
            {
                $this->response->statusCode(500);
                return json_encode("We can't add your record to database. Try again.");
            }
        }
        else
        {
            $this->response->statusCode(500);
            return json_encode($validate);
        }
    }

}

?>
