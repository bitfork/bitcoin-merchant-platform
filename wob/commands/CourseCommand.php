<?php

Yii::import("application.modules.wob.components.*");

class CourseCommand extends CConsoleCommand
{
	public function run($args)
	{
		Wob::startCourseCurrency();
		return 0;
	}
}