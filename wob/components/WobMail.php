<?php
class WobMail
{
	private $_admin_email = null;
	private $_admin_from = null;

	public function __construct($admin_email, $admin_name, $view_path)
	{
		$this->_admin_email = $admin_email;
		$this->_admin_from = $admin_email;
		if (!empty($admin_name))
			$this->_admin_from = $admin_name .'<'. $admin_email .'>';
		$this->_view_path = $view_path;
		if (empty($this->_view_path))
			$this->_view_path = 'wob.views.email';
	}

	/**
	 * вернет в html шаблоне
	 * @param $data
	 * @param null $view
	 * @return mixed
	 */
	private function getTemplate($data, $view = null)
	{
		if(isset(Yii::app()->controller))
			$controller = Yii::app()->controller;
		else
			$controller = new CController('Shop');

		if ($view===null)
			$view = 'template';

		if (!is_array($data)) {
			$data = array('content'=>$data);
		}

		return $controller->renderPartial($this->_view_path .'.'. $view, $data, true);
	}

	/**
	 * отправить email
	 * @param $email
	 * @param $subject
	 * @param $message
	 * @return bool
	 */
	public function send($email, $subject, $message, $view = false)
	{
		$headers = "MIME-Version: 1.0\r\nFrom: $this->_admin_from\r\nReply-To: $this->_admin_email\r\nContent-Type: text/html; charset=utf-8";
		if ($view!==false)
			$message = $this->getTemplate($message, $view);
		$message = wordwrap($message, 70);
		$message = str_replace("\n.", "\n..", $message);
		return mail($email,'=?UTF-8?B?'.base64_encode($subject).'?=',$message,$headers);
	}
}