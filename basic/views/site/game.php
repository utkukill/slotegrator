<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Game';
$this->params['breadcrumbs'][] = $this->title;



?>
<div class="site-game">
    <h1><?= Html::encode($this->title) ?></h1>
    <center>
    <h3><?php isset($prize) ? "Congratulations! You have won 100 money!" : "You won nothing" ?></h3>

    <p>
    	<p>Prize pool: $<?php echo $bank_moneys["val"].
    	", ".$bank_points["val"].
    	" bonus, ".$bank_things." things"; ?></p>
        <p><a class="btn btn-lg btn-danger" href="index.php?r=site%2Fgame&start=1">Run roulett!</a></p>
    </p>

    <hr>
    <table class="table table-striped" style="width: 30%">
    	<tr>
    		<th>Your money won</th>
    		<th>Your bonus won</th>
    		<th>Your things won</th>
    	</tr>
    	<tr>
    		<td>
	    		<?php
	    			echo $balance_moneys["sum"];
	    		?>
    		</td>
    		<td>
	    		<?php
	    			echo $balance_points["sum"];
	    		?>
    		</td>
    		<td>

	    		<?php
	    			if(count($balance_things) >= 1) {
	    				foreach($balance_things as $things) {
	    					echo $things["val"].", ";
	    				}
	    			} else {
	    				echo "you have not won things";
	    			}

	    		?>
    		</td>
    	</tr>

    </table>
</div>
