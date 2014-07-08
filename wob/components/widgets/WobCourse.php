<?php
class WobCourse extends CWidget
{
	public function run()
	{
		$pairs = WobPair::model()->pay()->findAll();
		$pair = $pairs[0];
		unset($pairs[0]);
		$this->render('course', array(
			'pair'=>$pair,
			'pairs'=>$pairs
		));
	}
}