<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of RecordHelper
 *
 * @author awojtys
 */
APP::import('Model', 'Activity');
APP::import('Model', 'Record');
APP::import('Model', 'Application');
APP::import('Model', 'Information');
APP::import('Model', 'Student');
APP::import('Model', 'Child');
APP::import('Model', 'Payment');
class RecordHelper {
    protected $_data;
    protected $_default_keys = array(
        'material_id', 
        'material_value', 
        'priority', 
        'student_attention', 
        'student_card',
        'student_name',
        'student_phone',
        'student_email',
        'student_profession',
        'student_surname',
        'training_id'
    );
    protected $_numeric_keys = array(
        'material_id',
        'material_value',
        'priority',
        'student_phone',
        'student_profession',
        'training_id'
    );
    protected $_required_keys = array(
        'student_name',
        'student_surname',
        'student_phone',
        'student_email',
        'student_profession',
        'child_name',
        'child_surname',
        'child_age'
    );
    
    /**
     * Constructor get request
     * 
     * @param type $data JSON Request
     */
    public function __construct($data) {
        $this->_data = $data;
    }
    
    /**
     * Method to validated data and check avaibility
     */
    public function validData()
    {
        $this->_trimAll();
        if($this->_check_avaibility() === false)
        {
            return 'We have not enought place for your group.';
        }
        //validate data
            if($this->_validateRequest() !== true)
            {
                return $this->_validateRequest();
            }
            if($this->_validateRequired() !== true)
            {
                return $this->_validateRequired();
            }
            if($this->_validateNumericInputs() !== true)
            {
                return $this->_validateNumericInputs();
            }
            if($this->_validatePriorities() !== true)
            {
                return $this->_validatePriorities();
            }
            if($this->_validateCard() !== true)
            {
                return $this->_validateCard();
            }
            if($this->_validateEmail() !== true)
            {
                return  $this->_validateEmail();
            }
        
        return true;
    }
    
    /**
     * Method to prepare data
     */
    public function prepareData()
    {
        //check students and childs
        $this->_mergeChildData();
        $this->_mergeStudentData();
        $this->_checkChilds();
    }
    
    /**
     * Method check if training is avaibility
     * 
     * @return boolean 
     */
    protected function _check_avaibility()
    {
        $activity = new Activity();
        
        $avaibility = $activity->findByTrainingId($this->_data['training_id']);
        if($avaibility['Activity']['avaibility'] <  $this->_primitiveStudentsNumber() + $this->_primitiveChildsNumber())
        {
            return false;
        }
    }
    
    /**
     * Method check how many students have
     * 
     * @return int Number of students
     */
    protected function _primitiveStudentsNumber()
    {
        if(is_array($this->_data['student_name']))
        {
            return count($this->_data['student_name']);
        }
        else
        {
            return 1;
        }
    }
    
    /**
     * Method check how many childs have
     * 
     * @return int Number of childs
     */
    protected function _primitiveChildsNumber()
    {
        if(array_key_exists('child_name', $this->_data))
        {
            if(is_array($this->_data['child_name']))
            {
                return count($this->_data['child_name']);
            }
            else
            {
                return 1;
            }
        }
    }
    
    /**
     * Method delete whitespace from start and end of all variables
     */
    protected function _trimAll()
    {
        foreach($this->_data as $keys => $value)
        {
            if(is_array($this->_data[$keys]))
            {
                foreach($this->_data[$keys] as $key => $value)
                {
                    $this->_data[$keys][$key] = trim($value);
                }
            }
            else
            {
                $this->_data[$keys] = trim($value);
            }
        }
    }
    
    /**
     * Method prepared array with all students data from parts
     */
    protected function _mergeStudentData()
    { 
        if(is_array($this->_data['student_name']))
        {
            $i = 0;
            foreach($this->_data['student_name'] as $key => $name)
            {
                $this->_data['students'][$i]['name'] = $this->_data['student_name'][$key];
                $this->_data['students'][$i]['surname'] = $this->_data['student_surname'][$key];
                $i++;
            }
            unset($this->_data['student_name']);
            unset($this->_data['student_surname']);
        }
        else
        {
            $this->_data['students'][0]['name'] = $this->_data['student_name'];
            $this->_data['students'][0]['surname'] = $this->_data['student_surname'];
            unset($this->_data['student_name']);
            unset($this->_data['student_surname']);
        }
    }
    
    
    /**
     * Method prepared array with all childs data from parts
     */
    protected function _mergeChildData()
    {
        
        if(array_key_exists('child_name', $this->_data))
        {
            if(is_array($this->_data['child_name']))
            {
                $i = 0;
                foreach($this->_data['child_name'] as $key => $name)
                {
                    $this->_data['childs'][$i]['name'] = $this->_data['child_name'][$key];
                    $this->_data['childs'][$i]['surname'] = $this->_data['child_surname'][$key];
                    $this->_data['childs'][$i]['age'] = $this->_data['child_age'][$key];
                    $i++;
                }
                unset($this->_data['child_name']);
                unset($this->_data['child_surname']);
                unset($this->_data['child_age']);
            }
            else
            {
                $this->_data['childs'][0]['name'] = $this->_data['child_name'];
                $this->_data['childs'][0]['surname'] = $this->_data['child_surname'];
                $this->_data['childs'][0]['age'] = $this->_data['child_age'];
                unset($this->_data['child_name']);
                unset($this->_data['child_surname']);
                unset($this->_data['child_age']);
            }
        }
    }
    
    /**
     * Method return number of childs
     * 
     * @return int Number of childs
     */
    protected function _manyChilds()
    {
        if(array_key_exists('child_name', $this->_data))
        {
            return count($this->_data['childs']);
        }
        else
        {
            return 0;
        }
    }
    
    /**
     * Method returned number of students
     * 
     * @return int Number of students 
     */
    protected function _manyStudents()
    {
        return count($this->_data['students']); 
    }
    
    /**
     * Method check if child is really child
     */
    protected function _checkChilds()
    {
        if(array_key_exists('childs', $this->_data))
        {
            foreach($this->_data['childs'] as $key => $value)
            {
                if($value['age'] > 11)
                {
                    array_push($this->_data['students'], array('name' => $value['name'], 'surname' => $value['surname']));
                    unset($this->_data['childs'][$key]);
                }
            }
        }
    }
    
    /**
     * Method validate required inputs
     * 
     * @return string|boolean Return Error if string or true if correct
     */
    protected function _validateRequired()
    {
        foreach($this->_required_keys as $key)
        {
            if(array_key_exists($key, $this->_data))
            {
                if(is_array($this->_data[$key]))
                {
                    foreach ($this->_data[$key] as $value)
                    {
                        if(empty($value))
                        {
                            return "You don't have values in required inputs";
                        }
                    }
                }
                else
                {
                    if(empty($this->_data[$key]))
                    {
                        return "You don't have values in required inputs";
                    }
                }
            }
        }
        return true;
    }
    
    /**
     * Method validate if all of default keys are exist in JSON request
     * 
     * @return string|boolean Return Error if string or true if correct
     */
    protected function _validateRequest()
    {
        foreach ($this->_default_keys as $key)
        {
            if(!array_key_exists($key, $this->_data))
            {
                return 'You changed names of inputs!';
            }
        }
        return true;
    }
    
    /**
     * Method validate if inputs where are must be numbers, are numbers
     * 
     * @return string|boolean Return Error if string or true if correct
     */
    protected function _validateNumericInputs()
    {
        
        foreach($this->_numeric_keys as $key)
        {
            if(is_array($this->_data[$key]))
            {
                foreach($this->_data[$key] as $value)
                {
                    if((!is_numeric($value) || (int)$value < 0) && $value != '')
                    {
                        return 'You have letters in number input or number is negative!';
                    }
                }
            }
            else
            {
                if((!is_numeric($this->_data[$key]) || (int)$value < 0) && $value != '')
                {
                    return 'You have letters in number input or number is negative!';
                }
            }
        }
        
        return true;
    }
    
    /**
     * Validate priorities of activities
     * 
     * @return string|boolean Return Error if string or true if correct
     */
    protected function _validatePriorities()
    {
        if($this->_data['priority'][0] != '' || $this->_data['priority'][1] != '' || $this->_data['priority'][2] != '')
        {
            if(!($this->_data['priority'][0] != '' && $this->_data['priority'][1] != '' && $this->_data['priority'][2] != ''))
            return 'Some activities in first day are empty';
        }
        if($this->_data['priority'][3] != '' || $this->_data['priority'][4] != '' || $this->_data['priority'][5] != '')
        {
            if(!($this->_data['priority'][3] != '' && $this->_data['priority'][4] != '' && $this->_data['priority'][5] != ''))
            return 'Some activities in first day are empty';
        }
        if($this->_data['priority'][6] != '' || $this->_data['priority'][7] != '' || $this->_data['priority'][8] != '')
        {
            if(!($this->_data['priority'][6] != '' && $this->_data['priority'][7] != '' && $this->_data['priority'][8] != ''))
            return 'Some activities in first day are empty';
        }
        
        if(($this->_data['priority'][0] == $this->_data['priority'][1] || $this->_data['priority'][0] == $this->_data['priority'][2] || $this->_data['priority'][1] == $this->_data['priority'][2]) && ($this->_data['priority'][0] != '' && $this->_data['priority'][1] != '' && $this->_data['priority'][2] != ''))
        {
            return 'Each activity in first day must have other values.';
        }
        if(($this->_data['priority'][3] == $this->_data['priority'][4] || $this->_data['priority'][3] == $this->_data['priority'][5] || $this->_data['priority'][4] == $this->_data['priority'][5]) && ($this->_data['priority'][3] != '' && $this->_data['priority'][4] != '' && $this->_data['priority'][5] != ''))
        {
            return 'Each activity in second day must have other values.';
        }
        if(($this->_data['priority'][6] == $this->_data['priority'][7] || $this->_data['priority'][6] == $this->_data['priority'][8] || $this->_data['priority'][7] == $this->_data['priority'][8]) && ($this->_data['priority'][6] != '' && $this->_data['priority'][7] != '' && $this->_data['priority'][8] != ''))
        {
            return 'Each activity in third day must have other values.';
        }
        return true;
    }
    /**
     * Validate if user really have card
     * 
     * @return string|boolean Return Error if string or true if correct
     */
    protected function _validateCard()
    {
        if((array_key_exists('if_card', $this->_data) && $this->_data['student_card'] == '') || (!array_key_exists('if_card', $this->_data) && $this->_data['student_card'] != ''))
        {
            return 'You have error with card!';
        }
        return true;

    }
    
    protected function _validateEmail()
    {
        if (filter_var($this->_data['student_email'], FILTER_VALIDATE_EMAIL)) 
        {
            return true;
        }
        else
        {
            return 'You have error with card!';
        }
        

    }

    /**
     * Method prepare list of professions of group lider
     * 
     * @return string return list of profession of group lider
     */
    protected function _prepareProfessions()
    {
        $id = '';
        if(is_array($this->_data['student_profession']))
        {
            foreach($this->_data['student_profession'] as $profession)
            {
                $id .= $profession.',';
            }
            return $id;
        }
        else
        {
            return $this->_data['student_profession'];
        }
    }
    
    /**
     * Method return studends data
     * 
     * @return array Array with all students
     */
    public function returnPayment()
    {
        $price_for_students = count($this->_manyStudents()) * 200;
        $price_for_materials = 0;
        foreach($this->_data['material_value'] as $value)
        {
            $price_for_materials = $price_for_materials + ($value*10);
        }
        $price = $price_for_materials+$price_for_students;
        return array('payment_status' => 'Processing', 'price' => $price);
    }
    
    public function returnStudents($record_id)
    {
        foreach($this->_data['students'] as $key => $student)
        {
            $this->_data['students'][$key]['record_id'] = $record_id;
        }
        return $this->_data['students'];
    }
    
    /**
     * Method return childs data
     * 
     * @return array Array with all childs
     */
    public function returnChilds($record_id)
    {
        if(array_key_exists('childs', $this->_data))
        {
            foreach($this->_data['childs'] as $key => $student)
            {
                $this->_data['childs'][$key]['record_id'] = $record_id;
            }
            return $this->_data['childs'];
        }
    }
    
    public function prepareTraining()
    {
        
    }
    
    /**
     * Method prepare all data of informations
     * 
     * @return mix Data for information
     */
    public function returnInformation()
    {
        $data = array(
                'student_number' => $this->_manyStudents(), 
                'child_number' => $this->_manyChilds(), 
                'professions' => $this->_prepareProfessions(), 
                'phone' => $this->_data['student_phone'], 
                'email' => $this->_data['student_email'],
                'attention' => $this->_data['student_attention'], 
                'card' => $this->_data['student_card']
        );
        return $data;
    }
    
    /**
     * Method return studends data
     * 
     * @return array Array with all student
     */
    public function returnApplication()
    {
        $data = array();
        foreach($this->_data['priority'] as $key => $priority)
        {
            $key++;
            if($priority == '')
            {
                $priority = 0;
            }
            $data['priority_activity_'.$key] = $priority;
        }
    
        foreach($this->_data['material_id'] as $key => $id)
        {
            $key++;
            $data['material_'. $key .'_id'] = $id;
        }
        foreach($this->_data['material_value'] as $key => $value)
        { 
           $key++;
            $data['material_'. $key .'_number'] = $value;
        }
        return $data;
    }
    
    public function changeAvaibility()
    {
        $activity = new Activity();
        
        $avaibility = $activity->findAllByTrainingId($this->_data['training_id']);
        foreach ($avaibility as $key => $value)
        {
            $avaibility[$key]['Activity']['avaibility'] = $value['Activity']['avaibility'] - $this->_manyStudents() - $this->_manyChilds();
        }
        if($activity->saveAll($avaibility))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    public function deleteRecord($record_id)
    {
        $record = new Record();
        $record_data = $record->findById($record_id);
        $record -> delete($record_id, false);
        
        //To repair. Problem with delate application
        $application_id = $record_data['Record']['application_id'];
        $application = new Application();
        $application ->delete($application_id, false);
       
        $information_id = $record_data['Record']['information_id'];
        $information = new Information();
        $information->delete($information_id, false);
        
        $payment_id = $record_data['Record']['payment_id'];
        $payment = new Payment();
        $payment -> delete($payment_id, false);               
        
        $student = new Student();
        $student_data = $student -> findAllByRecordId($record_id);
        
        foreach($student_data as $key => $value)
        {
            $student->delete($value['Student']['id'], false);
        }
        
        $child = new Child();
        $child_data = $child -> findAllByRecordId($record_id);
        if(!empty($child_data))
        {
            foreach ($child_data as $key => $value)
            {
                $child->delete($value['Child']['id'], false);
            }
        }
        
    }
}

?>
