<?php
class WobActiveRecord extends CActiveRecord
{
	public function behaviors()
	{
		return array(
			'AutoTimestampBehavior' => array(
				'class' => 'wob.components.behaviors.AutoTimestampBehavior',
			)
		);
	}

	public function defaultScope()
	{
		return array(
			'condition' => $this->getTableAlias(false, false) . ".is_active=1",
		);
	}
}