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
    public $_data;
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
        $data = array('Training' => array(
            'id' => $this->_data['id'],
            'name' => $this->_data['training_name'],
            'start_date' => $this->_data['training_start_date'],
        ));
        return $data;
    }
    
    private function _returnActivities()
    {
        $date = strtotime($this->_data['training_start_date']);
        $data['Activity'] = array();
        $seconds = 0;
        for($i=0; $i<=2; $i++)
        {
            $prepare = array(
               'id' =>  $this->_data['activity_id'][$i],
               'name' =>  $this->_data['name'][$i],
               'date' => date('Y-m-d', $date+$seconds),
               'time_start' =>  $this->_data['time_start'][$i],
               'time_end' =>  $this->_data['time_end'][$i],
            );
            $data['Activity'][$i] = $prepare;
            $seconds += 86400;
        }
        return $data;
    }
}

?>
