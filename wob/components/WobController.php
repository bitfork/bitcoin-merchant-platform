<?php
class WobController extends CController
{
	public $layout;
	public $menu=array();
	public $breadcrumbs=array();

	public $h1 = '';
	public $pageTitle = '';
	public $pageKeywords = '';
	public $pageDescription = '';

	public function init()
	{
		parent::init();
		
		$this->layout = Wob::module()->mainLayout;

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