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
class RecordHelper {
    protected $_data;
    protected $_many_childs;
    protected $_many_students;
    protected $_child_to_student;
    protected $_student_number;
    protected $_child_number;
    protected $_default_keys = array(
        'material_id', 
        'material_value', 
        'priority', 
        'student_attention', 
        'student_card',
        'student_name',
        'student_phone',
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
     * Method to return prepared data
     */
    public function returnData()
    {
        $this->_trimAll();
        //validate data
        $errors = array(
            $this->_validateRequest(),
            $this->_validateNumericInputs(),
            $this->_validateRequired(),
            $this->_validatePriorities(),
            $this->_validateCard()
        );
       
        foreach($errors as $error)
        {
            if($error !== true)
            {
                print_r($error);
                return $error;
            }
        }
        
        //check students and childs
        $this->_makeArrayFromStudents();
        $this->_checkChilds();
        $this->_manyChilds();
        $this->_manyStudents();
      
        //check avaibility
        if($this->_check_avaibility() === false)
        {
            return 'We have not enought place for your group.';
        }
        
        //prepare all data to send to database
        $information = $this->_prepareInformation();
        $application = $this->_prepareApplication();

        
    }
    
    protected function _check_avaibility()
    {
        $activity = new Activity();
        $avaibility = $activity->findByTrainingId($this->_data['training_id']);
        if($avaibility['Activity']['avaibility'] < $this->_child_number + $this->_student_number)
        {
            return false;
        }
    }
    
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
    
    protected function _makeArrayFromStudents()
    {
        if(!is_array($this->_data['student_name']))
        {
            $this->_data['student_name'] = array($this->_data['student_name']);
            $this->_data['student_surname'] = array($this->_data['student_surname']);
        }
    }
    
    protected function _manyChilds()
    {
        if(array_key_exists('child_name', $this->_data))
        {
            if(is_array($this->_data['child_name']))
            {
                $this->_child_number = count($this->_data['child_name']);
            }
            else
            {
                $this->_child_number = 1;
            }
        }
        else
        {
            $this->_child_number = 0;
        }
    }
    
    protected function _manyStudents()
    {
        if(is_array($this->_data['student_name']))
        {
            $this->_student_number = count($this->_data['student_name']);
        }
        else
        {
            $this->_student_number = 1;
        }
    }
    
    protected function _checkChilds()
    {
        if(array_key_exists('child_age', $this->_data))
        {
            if(is_array($this->_data['child_age']))
            {
                for($i = 0; $i < count($this->_data['child_age']); $i++)
                {
                    if($this->_data['child_age'][$i] > 11)
                    {
                        array_push($this->_data['student_name'], $this->_data['child_name'][$i]);
                        array_push($this->_data['student_surname'], $this->_data['child_surname'][$i]);
                        unset($this->_data['child_name'][$i]);
                        unset($this->_data['child_surname'][$i]);
                    }
                }
            }
            else 
            {
                if($this->_data['child_age'] > 11)
                {
                        array_push($this->_data['student_name'], $this->_data['child_name']);
                        array_push($this->_data['student_surname'], $this->_data['child_surname']);
                        unset($this->_data['child_name']);
                        unset($this->_data['child_surname']);
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
    
    protected function _prepareStudents()
    {
        
    }
    
    protected function _prepareChilds()
    {
        
    }
    
    protected function _prepareTraining()
    {
        
    }
    
    protected function _prepareInformation()
    {
        $data = array('Information' => array('student_number' => $this->_student_number, 'child_number' => $this->_child_number, 'professions' => $this->_prepareProfessions()));
        return $data;
    }
    
    protected function _prepareApplication()
    {
        $data['Application'] = array();
        print_r($this->_data);
        foreach($this->_data['priority'] as $key => $priority)
        {
            $data['Application']['priority_activity_'.$key] = $priority;
        }
        print_r($data);
    }
    
}

?>
