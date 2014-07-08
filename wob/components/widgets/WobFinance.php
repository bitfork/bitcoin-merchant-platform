<?php
class WobFinance extends CWidget
{
	public function run()
	{
		if (Yii::app()->user->getState('wob_select_shop')===null) {
			return;
		}
		$wallets = WobUsersWallet::model()->my()->findAll();
		if (isset($_POST['id_wallet_select'])) {
			Yii::app()->user->setState('wob_select_wallet', (int)$_POST['id_wallet_select']);
		}
		if (count($wallets)>0) {
			if (Yii::app()->user->getState('wob_select_wallet')===null) {
				Yii::app()->user->setState('wob_select_wallet', $wallets[0]->id);
				$wallet_select = $wallets[0];
			} else {
				$wallet_select = WobUsersWallet::model()->my()->findByPk(Yii::app()->user->getState('wob_select_wallet'));
			}
		} else {
			$wallet_select = false;
		}
		$this->render('finance', array(
			'id_shop'=>Yii::app()->user->getState('wob_select_shop'),
			'wallets'=>$wallets,
			'wallet_select'=>$wallet_select,
		));
	}
}