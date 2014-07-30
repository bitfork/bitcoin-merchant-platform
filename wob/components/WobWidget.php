<?php
class WobWidget extends CWidget
{
	public function getViewPathTheme()
	{
		$path = 'webroot.themes.'.Yii::app()->theme->name.'.views.wob.components.';
		if (!file_exists(Yii::getPathOfAlias($path).DIRECTORY_SEPARATOR.$this->view.'.php'))
			return '';
		return $path;
	}
}