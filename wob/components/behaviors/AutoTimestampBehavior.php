<?php
class AutoTimestampBehavior extends CActiveRecordBehavior {
 
    /**
    * Поле которое содержит дату создания записи
    */
    public $created = 'create_date';
    /**
    * Поле которое содержит дату редактирования записи
    */
    public $modified = 'mod_date';

    public function beforeValidate($on) {
        if ($this->Owner->isNewRecord)
            $this->Owner->{$this->created} = new CDbExpression('NOW()');
        
        $this->Owner->{$this->modified} = new CDbExpression('NOW()');
 
        return true;    
    }
}
