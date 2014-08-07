<?php
class WobCourse extends WobWidget
{
	public $view = 'course';

	public function run()
	{
		$pairs = WobPair::model()->pay()->findAll('course>1');
		$pair = $pairs[0];
		unset($pairs[0]);
		$this->render($this->getViewPathTheme().$this->view, array(
			'pair'=>$pair,
			'pairs'=>$pairs
		));
	}
}