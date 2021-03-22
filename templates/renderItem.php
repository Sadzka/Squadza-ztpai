<p class="iconlarge">
	<img src="public/img/icons/itemborder.png" />
	<img class="itemicon" src="public/img/icons/<?= $item->getIcon() ?>.jpg" />
</p>
				
<table class="tooltip">
	<th>
		<div class="item">
			<span class="q<?= $item->getQuality() ?> name"> <?= $item->getName() ?> </span>
			
			<div id="item-id"><?= $item->getId() ?></div>
			<div class="item-id-visible">ID: <?= $item->getId() ?></div> <br>
			
			<?= is_null($item->getItemLevel())
			? ''
			: '<span class="ilvl">Item Level <span id="ilvlvalue">' . $item->getItemLevel() . '</span></span> <br>' ?>

			<?= is_null($item->isBindOnPickUp())
			? ''
			: '<span id="boe">' . ($item->isBindOnPickUp() ? 'Binds when pick up' : 'Binds on equip') . '</span> <br>' ?>
			


			<?php 
				$count = $item->isUnique();
				if ($count != 0) {
					echo '<span id="Unique">Unique ';
					if ($item->isUnique() > 1)
						echo '(' . $item->isUnique() . ')';
					echo '</span> <br>';
				}
			?>

			<span id="eqtype"> <?= $item->getSlot() != '' ? $item->getSlot() : '' ?> </span>
			<span id="ittype" class="alignright"> <?= $item->getEquipType()?> </span><br>

			<?php
				$damage = $item->getDamage();
				
				if ($damage != null) {
					echo '<span id="damage">' . $damage[0] . ' - ' . $damage[1] . ' Damage</span>';
					if ($item->getSpeed() != null){
						echo '<span id="speed" class="alignright">' . $item->getSpeed() . ' Speed</span> <br>';
						
						
						echo '<span id="dps">('
						. round(($damage[0] + $damage[1])/(2*$item->getSpeed()), 2)
						. ' Damage per second)</span> <br>';
					}
					else echo '<br>';
				}
			?>

			<?php
				if (!is_null($item->getStats())) 
				{
					foreach( $item->getStats() as $stat) {
						if (strtolower($stat['stat']) == 'stamina'
						||  strtolower($stat['stat']) == 'strength'
						||  strtolower($stat['stat']) == 'intelect'
						||  strtolower($stat['stat']) == 'agility'
						||  strtolower($stat['stat']) == 'spirit') {
							echo '<span> +' . $stat['value'] . ' ' . $stat['stat'] . '</span> <br>';
						}
						else {
							echo '<span class="q2"> +' . $stat['value'] . ' ' . $stat['stat'] . '</span> <br>';
						}
					}
				}
			?>

			
			<?php
				if ($item->getSockets()[0] != null) {
					echo '<div class="sockets"><br>';

					foreach($item->getSockets() as $socket) {
						if (!is_null($socket))
							echo '<p class="socket q1 s-' . $socket . '"></p>';
					}
					$x = $item->getSocketBonus();
					if (!is_null($x['stat']))
						echo '<span class="q1"> Socket Bonus: +' . $x['value'] . ' ' . $x['stat'] . '</span>';
					
					echo '<br></div>';
				}
			?>
			
			
			<?= $item->getRequiredLevel() != 0 ? '<span> Required Level ' . $item->getRequiredLevel() .'</span> <br>' : '' ?> 
			
			<div class="moneys">
				<?php
					$price = $item->getSellPrice();
					if ($price == 0) {
						echo 'No Sell Price ';
					}
					else {
						echo 'Sell Price: ';

						if ( intval($price/10000) % 100 != 0)
							echo round($price/10000 % 100) . '<p class="money m-gold" />';

						if ( intval($price/100) % 100 != 0)
							echo round($price/100 % 100) . '<p class="money m-silver" />';

						if ($price % 100 != 0)
							echo round($price % 100) . '<p class="money m-copper" />';

					}
				?>
			</div>
			
			<th class="top-right">
			
			<tr>
				<th class="bottom-left"></th>
				<th class="bottom-right"></th>
			</tr>
			
			<!-- <th style="background-position: top right;"></th> -->
			<!-- <tr><th style="background-position: bottom left"></th><th style="background-position: bottom right"></th></tr>  -->
			<br>
		</div>
	</th>
</table>