<?php $this->set('title_for_layout', " Create | Select Language"); ?>
<div class="row">
    <div class="span12">
     <ol class="track-progress" data-steps="4">
       <li class="done">
         <span>Image Upload</span>
         <i></i>
       </li><li class="done">
         <span>Text Mask</span>
       </li><li class="now">
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
        <h3>Select Language</h3>
        <legend>Please input title and select language.</legend>
<?php echo $this->BootstrapForm->create('Title');?>
<?php
echo $this->BootstrapForm->input('title',$langs);
echo $this->BootstrapForm->select('lang_code',$langs);
echo $this->BootstrapForm->submit(__('Save'));
?>
<?php echo $this->BootstrapForm->end();?>
	</div>
</div>

