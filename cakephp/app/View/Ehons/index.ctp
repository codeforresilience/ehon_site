<?php $this->set('title_for_layout', "For all the children"); ?>
<style type="text/css">
.item img{
	-moz-box-shadow: 3px 3px 3px #666;    /* firefox　*/
	-webkit-box-shadow: 3px 3px 3px #666;  /* safari、chorme */
}
</style>

<div class="row">
	<div class="span12">
<div id="myCarousel" class="carousel slide" style="background-image:url('/img/topbg.jpg');">
 
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <li data-target="#myCarousel" data-slide-to="1"></li>
    <li data-target="#myCarousel" data-slide-to="2"></li>
  </ol>
 
  <div class="carousel-inner">


<?php 
	for($i=0;$i<count($newEhons);$i++){
?>
    <div class="<?php echo $i==0?'active':'';?> item" style="text-align:center;#EEE;margin:10px;padding:10px;">
    	<div style="margin:0 auto;">
    	<?php
echo ('<a href="/ehons/view/'.$newEhons[$i]['Ehon']['id'].'"><img style="height:300px" src="/files/attachment/file/'.$newEhons[$i]['Attachment'][0]['id'].'/'.$newEhons[$i]['Attachment'][0]['file'].'"/></a>');
    	?>
    </div>
    </div>
<?php
}
?>

  </div>

  <a class="carousel-control left" href="#myCarousel" data-slide="prev">&lsaquo;</a>
  <a class="carousel-control right" href="#myCarousel" data-slide="next">&rsaquo;</a>
</div>
	</div>
</div>

<div class="row">
	<div class="span9">
		<h3><?php echo __('List %s', __('ehon'));?></h3>
		<table class="table">
		<?php foreach ($ehons as $ehon): ?>
			<tr>
				<td style="width:370px">
					<?php
						$roop=count($ehon['Attachment']);
						if($roop>3){
							$roop=3;
						}
						for($i=0;$i<$roop;$i++){
							echo ('<a href="/ehons/view/'.$ehon['Ehon']['id'].'"><img src="/files/attachment/file/'.$ehon['Attachment'][$i]['id'].'/thumb80_'.$ehon['Attachment'][$i]['file'].'"/></a>');
						}
					?>
				</td>
				<td>
					<?php 
					$roop=count($ehon['Title']);
					$andMsg="";
					if($roop>3){
						$andMsg=" ...more";
						$roop=3;
					}
					for($i=0;$i<$roop;$i++){
						$title=$ehon['Title'][$i];
						echo($title["title"]." (".$langs[$title["lang_code"]].")<br/>");
					} 
					echo $andMsg;
					?>
				</td>

				<td class="actions">
					<?php echo $this->Html->link(__('View'), array('action' => 'view', $ehon['Ehon']['id'])); ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</table>

		<?php echo $this->BootstrapPaginator->pagination(); ?>
	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link(__('Create %s', __('ehon')), array('action' => 'create')); ?></li>
		</ul>
		</div>
	</div>
</div>