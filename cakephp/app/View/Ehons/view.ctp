<style type="text/css">
.pagebox {
background-color:#EFEFEF;
-moz-box-shadow: 2px 2px 2px #DDD;    /* firefox　*/
-webkit-box-shadow: 2px 2px 2px #DDD;  /* safari、chorme */
padding:1px;
}
</style>

<div class="row">
	<div class="span9">
        <legend>Please click the language you want to read</legend>
		<div>
			<?php foreach( $ehon['Attachment'] as $att ){ ?>
				<img class="pagebox" src="/files/attachment/file/<?php echo $att['id']; ?>/thumb150_<?php echo $att['file']; ?>"/>
			<?php } ?>
		</div>

		<hr/>
		<?php
		$pageTitle="";
		foreach( $ehon['Title'] as $title ){
			$pageTitle.=$title["title"]." ";
		?>

        <h3>
        	<?php echo $this->Html->link($title["title"], array('controller'=>'binders','action'=>'pdf',$ehon["Ehon"]["id"],$title["lang_code"]),array('target'=>'translation') ); ?>
			 : <?php echo $langs[$title["lang_code"]]; ?>
		</h3>

			<?php echo $this->Html->link('<span class="icon-large icon-download"></span> Download', array('controller'=>'binders','action'=>'pdf',$ehon["Ehon"]["id"],$title["lang_code"]),array('class'=>'btn','target'=>'translation','escape' => false) ); ?>
			<a href="/binders/pdf/<?php echo $ehon["Ehon"]["id"];?>/<?php echo $title["lang_code"]?>" ></a>
			<?php echo $this->Html->link('<span class="icon-large icon-edit"></span> Edit Translation', array('action'=>'translation',$ehon["Ehon"]["id"],$mask['Mask']['id'],$title["lang_code"]),array('class'=>'btn','escape' => false)); ?>
		<hr/>
		<?php } ?>
		<?php $this->set('title_for_layout', $pageTitle); ?>

	</div>
	<div class="span3">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
		<ul class="nav nav-list">
			<li class="nav-header"><?php echo __('Actions'); ?></li>
			<li><?php echo $this->Html->link('<span class="icon-large icon-book-open"></span> Create New Language', array('action'=>'translation',$ehon["Ehon"]["id"]),array('escape'=>false)); ?>
			</li>
			<li><s>Edit This Ehon</s></li>
			<li><?php echo $this->Form->postLink(__('Delete Ehon'), array('action' => 'delete', $ehon['Ehon']['id']), null, __('Are you sure you want to delete # %s?', $ehon['Ehon']['id'])); ?> </li>
		</ul>
		</div>
	</div>
</div>

