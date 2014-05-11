<?php $this->set('title_for_layout', " Create | Image Upload"); ?>
<div class="row">
    <div class="span12">
     <ol class="track-progress" data-steps="4">
       <li class="now">
         <span>Image Upload</span>
         <i></i>
       </li><li>
         <span>Text Mask</span>
       </li><li>
         <span>Select Language</span>
       </li><li>
         <span>Translate</span>
         <i></i>
       </li>
     </ol>
    </div>
</div>
<div class="row">
	<div class="span12">
		<h3>Image Upolad</h3>
		<legend>Please ehon image upload.</legend>
		<?php echo $this->BootstrapForm->create('Ehon', array('class' => 'form-horizontal','type' => 'file'));?>
			<fieldset>
				<div id="images">
					<?php echo $this->BootstrapForm->input('Attachment.0.file', array('label'=>'Page Image','type' => 'file')); ?>
					<?php echo $this->BootstrapForm->hidden('Attachment.0.seq', array('default'=>0)); ?>
					<p id="images_ins"></p>
				</div>
				<p style="margin-left:180px"><a class="btn" id="images_add" href="#">add image upload btn</a></p>
			</fieldset>
		<?php echo $this->BootstrapForm->input('copyright'); ?>
		<?php echo $this->BootstrapForm->submit(__('Create!'));?>
		<?php echo $this->BootstrapForm->end();?>
	</div>
	<script type="text/javascript">
		var imagesFormfile=$('.control-group','#images').get(0).outerHTML;
		var imagesFormseq=$("input[type=hidden]",'#images').get(0).outerHTML;
		var imagesCount=0;
		$('#images_add').click(function(e){
			imagesCount++;
			$('#images_ins').before(imagesFormfile.replace(/0/g, imagesCount));
			$('#images_ins').before(imagesFormseq.replace(/0/g, imagesCount));
		});
	</script>
</div>