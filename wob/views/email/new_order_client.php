<p>Здравствуйте,</p>
<p>Вы перешли к оплате заказа в магазине <b><?php echo $shop_name; ?></b>. в сумме <b><?php echo $amount; ?></b></p>
<p>Если вы случайно закрыли окно оплаты, то можете вернуться к оплате по следующей ссылке: <?php echo CHtml::link('перейти', $this->createAbsoluteUrl('/wob/pay/index', array('hash'=>$order_hash))); ?></p>