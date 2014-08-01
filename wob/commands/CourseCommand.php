<?php

Yii::import("wob.components.*");

class CourseCommand extends CConsoleCommand
{
	public function run($args)
	{
		Wob::startCourseCurrency();
		return 0;
	}
}