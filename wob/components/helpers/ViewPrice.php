<?php
class ViewPrice
{
	public static function format($value, $currency = 'USD', $decimal_place = 2, $currency_round = '')
	{
		return Yii::app()->numberFormatter->format(',###.'. str_repeat('#', $decimal_place) .' ¤', $value, $currency) . $currency_round;
	}
}