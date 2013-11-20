<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Training
 *
 * @author awojtys
 */
class TrainingHelper {
    protected $_data;
    public function __construct(array $data) {
        $this->_data = $data;
    }
    public function returnArray()
    {
        $training = $this->_returnTraining();
        $activities = $this->_returnActivities();
        $data = array_merge($training, $activities);
        return $data;
    }
    
    private function _returnTraining()
    {
        if(array_key_exists('id', $this->_data))
        {
            $data = array('Training' => array(
                'id' => $this->_data['id'],
                'name' => $this->_data['training_name'],
                'start_date' => $this->_data['training_start_date'],
            ));
        }
        else
        {
            $data = array('Training' => array(
                'name' => $this->_data['name'],
                'start_date' => $this->_data['start_date'],
            ));
        }
        return $data;
    }
    
    private function _returnActivities()
    {
        array_key_exists('training_start_date', $this->_data) ? $date = strtotime($this->_data['training_start_date']) : $date = strtotime($this->_data['start_date']);
        $data['Activity'] = array();
        $seconds = 0;
        $number = 0;
        for($i=0; $i<=2; $i++)
        {
            for($j=0; $j<=2; $j++)
            {
                if(array_key_exists('activity_id', $this->_data))
                {
                    $prepare = array(
                       'id' =>  $this->_data['activity_id'][$number],
                       'name' =>  $this->_data['name'][$number],
                       'date' => date('Y-m-d', $date+$seconds),
                       'time_start' =>  $this->_data['time_start'][$number],
                       'time_end' =>  $this->_data['time_end'][$number],
                    );
                }
                else
                {
                    $prepare = array(
                    'name' => '',
                    'avaibility' => 15,
                    'date' => date('Y-m-d', $date+$seconds),
                    );
                }
                $data['Activity'][$number] = $prepare;
                $number++;
            }
            $seconds += 86400;
        }
        return $data;
    }
    
    public function returnNew()
    {
        $training = $this->_returnTraining();
        $activities = $this->_returnActivities();
        $data = array_merge($training, $activities);
        return $data;
    }
}

?>
