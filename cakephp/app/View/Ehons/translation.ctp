<?php $this->set('title_for_layout', " Create | Translate"); ?>
<style type="text/css">
.prevBase {
 position: relative;
 width: 920px;
 margin: 0;
 padding: 0;
}
.prevTarget {
 position: absolute;
 background-color: #000;
 opacity: 0.7;
 filter: alpha(opacity=70);
 -ms-filter: "alpha(opacity=70)";
 margin: 0;
 padding: 0;
}
#prevTrans {
 position: absolute;
 background-color: #fff;
 border:1px solid black;
 padding: 10px;
 width:320px;
}
#prevTrans textarea{
	width:300px;
	height:100px;
}
.popover-content {
    overflow: scroll;
    height: 10em;
}
#hint{
    display: none;
}
</style>
<div class="row">
    <div class="span12">
     <ol class="track-progress" data-steps="4">
       <li class="done">
         <span>Image Upload</span>
         <i></i>
       </li><li class="done">
         <span>Text Mask</span>
       </li><li class="done">
         <span>Select Language</span>
       </li><li class="now">
         <span>Translate</span>
         <i></i>
       </li>
     </ol>
    </div>
</div>
<div class="row">
    <div class="span12">
        <h3>Translate</h3>
        <legend>Please to translate selected portions.</legend>
<div class="prevBase">
	<img src="" id="prev" width="920" />
	<div id="prevPos1" class="prevTarget"></div>
	<div id="prevPos2" class="prevTarget"></div>
	<div id="prevPos3" class="prevTarget"></div>
	<div id="prevPos4" class="prevTarget"></div>
	<div id="prevTrans">
	<?php echo $this->BootstrapForm->create('Translation');?>
	<?php
	echo $this->BootstrapForm->input('translation',array('default' => isset($translation['Translation'])?$translation['Translation']['translation']:""));
	echo $this->BootstrapForm->submit(__('Save'));
	?>
	<?php echo $this->BootstrapForm->end();?>
	<div id="hint">
        refer to : 
		<?php foreach( $mask['Translation'] as $translation ){ ?>
        <script type="text/javascript">$("#hint").show();</script>
		<a href="#" rel="popover" data-trigger="click" data-placement="bottom" data-content="<?php echo htmlspecialchars(nl2br(htmlspecialchars($translation["translation"])));?>" title="<?php echo $langs[$translation["lang_code"]]; ?> translation" ><?php echo $langs[$translation["lang_code"]]; ?></a>
		<?php } ?>
	</div>
	</div>
</div>
<script type="text/javascript">
var width = <?php echo $mask['Mask']['width']?>/100;
var height = <?php echo $mask['Mask']['height']?>/100;
var x = <?php echo $mask['Mask']['x']?>/100;
var y = <?php echo $mask['Mask']['y']?>/100;
$(function(){

    baseImg = new Image();
    baseImg.src = "/files/attachment/file/<?php echo $mask['Attachment']['id']; ?>/<?php echo $mask['Attachment']['file']; ?>";
    baseImg.onload = function(){
    	$("#prev").attr("src",baseImg.src);

    	var clipX=Math.round(x*$("#prev").width());
    	var clipY=Math.round(y*$("#prev").height());
    	var clipW=Math.round(width*$("#prev").width());
    	var clipH=Math.round(height*$("#prev").height());

    	$("#prevPos1").css("top",0);
    	$("#prevPos1").css("left",0);
    	$("#prevPos1").css("width",$("#prev").width());
    	$("#prevPos1").css("height",clipY);
    	$("#prevPos2").css("top",clipY);
    	$("#prevPos2").css("left",0);
    	$("#prevPos2").css("width",clipX);
    	$("#prevPos2").css("height",clipH);
    	$("#prevPos3").css("top",clipY);
    	$("#prevPos3").css("left",clipX+clipW);
    	$("#prevPos3").css("width",$("#prev").width()-clipW-clipX);
    	$("#prevPos3").css("height",clipH);
    	$("#prevPos4").css("top",clipY+clipH);
    	$("#prevPos4").css("left",0);
    	$("#prevPos4").css("width",$("#prev").width());
    	$("#prevPos4").css("height",$("#prev").height()-clipH-clipY);

    	var tgW=$("#prevTrans").width()+30;
    	var tgH=$("#prevTrans").height()+30;
    	var mg=5;

    	var tgT=0;
    	var tgL=0;

    	if(clipX+clipW+tgW+mg < $("#prev").width()){
    		tgL=clipX+clipW+mg;
    	}else{
	 		tgL=clipX-tgW-mg;
    	}
    	if(clipY+clipH+tgW+mg < $("#prev").height()){
    		tgT=clipY;
    	}else{
    		tgT=clipY+clipH-tgH;
    	}
    	if(tgL<0) tgL=mg;
    	if(tgT<0) tgT=mg;
  		$("#prevTrans").css("top",tgT);
 		$("#prevTrans").css("left",tgL);


  //   	if($("#prev").width()/2<clipX){
	 //    	$("#prevTrans").css("left",10);
		// }else{
	 //    	$("#prevTrans").css("left",$("#prev").width()-$("#prevTrans").width()-30);
		// }
  //   	if($("#prev").height()/2<clipY){
	 //    	$("#prevTrans").css("top",10);
		// }else{
	 //    	$("#prevTrans").css("top",$("#prev").height()-$("#prevTrans").height()-30);
		// }

    }
});
</script>

