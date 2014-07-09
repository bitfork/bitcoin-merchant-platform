<ul class="nav navbar-nav">
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo '1 '. $pair->currency_1->code .' = '. ViewPrice::format($pair->course, $pair->currency_2->code, $pair->currency_2->round); ?> <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<?php foreach ($pairs as $pair) { ?>
				<li class="list-group-item">
					<?php echo '1 '. $pair->currency_1->code .' = '. ViewPrice::format($pair->course, $pair->currency_2->code, $pair->currency_2->round); ?>
				</li>
			<?php } ?>
		</ul>
	</li>
</ul>