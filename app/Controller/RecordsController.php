<?php

App::uses('RecordHelper', 'Lib');
class RecordsController extends AppController{
    public $uses = array('Material', 'Record', 'Profession', 'Payment', 'Student', 'Child', 'Activity');
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
        $records = $this->Record->find('all');
        if(!empty($records))
        {
            return json_encode($records);            
        }
        else
        {
            exit;
        }
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
        //load more data if admin looking in payment logs
        if(!empty($_GET['logs']))
        {
            $professions_id = explode(',', $record['Information']['professions']);
            
            if(count($professions_id) != 1)
            {
                array_pop($professions_id);
            }
            $profession = $this->Profession->find('all', array(
                'conditions' => array(
                    "Profession.id" => $professions_id
                )
            ));
            $activity = $this->Activity->findAllByTrainingId($record['Training']['id'], array('contain' => false));
            $student = $this->Student->findAllByRecordId($record['Record']['id'], array('contain' => false));
            $child = $this->Child->findAllByRecordId($record['Record']['id'], array('contain' => false));
            $record['Professions'] = $profession;
            $record['Activities'] = $activity;
            $record['Students'] = $student;
            $record['Childs'] = $child;
        }
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
