<p>- <b><?php echo $shop_name; ?></b></p>
<?php if (!empty($id_order_shop)) { ?>
	<p>- Номер заказа: <?php echo $id_order_shop; ?></p>
<?php } ?>
<?php if (!empty($email)) { ?>
	<p>- Email клиента: <?php echo $email; ?></p>
<?php } ?>
<p>- Сумма к оплате: <b><?php echo $amount; ?></b></p>