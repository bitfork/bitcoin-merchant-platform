<?php
class WobController extends CController
{
	public $layout = 'wob.views.layouts.wob';
	public $menu=array();
	public $breadcrumbs=array();

	public $h1 = '';
	public $pageTitle = '';
	public $pageKeywords = '';
	public $pageDescription = '';

	public function init()
	{
		parent::init();

		$this->h1 = 'WOB';
		$this->pageTitle = 'WOB';
		$this->pageKeywords = '';
		$this->pageDescription = '';
	}

	public function filters()
	{
		return array(
			'accessControl',
		);
	}
}