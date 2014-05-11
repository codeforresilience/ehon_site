<?php $this->set('title_for_layout', " Create | Text Mask"); ?>
<?php echo $this->BootstrapForm->create('Mask', array('class' => 'form-horizontal','type' => 'file'));?>
<div class="row">
    <div class="span12">
     <ol class="track-progress" data-steps="4">
       <li class="done">
         <span>Image Upload</span>
         <i></i>
       </li><li class="now">
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
	<div class="span8">
        <h3>Text Mask</h3>
        <legend>Please set the mask is traced with a cursor part of the text.</legend>
		<div>
			<?php foreach( $ehon['Attachment'] as $attachment ){ ?>
				<!--<a href="/ehons/mask/<?php echo $ehon['Ehon']['id']?>/<?php echo $attachment['id']?>">-->
				<img src="/files/attachment/file/<?php echo $attachment['id']; ?>/thumb80_<?php echo $attachment['file']; ?>" style="<?php echo $attachment['id']==$attId?"border:2px solid red;":""; ?>"/>
				<!--</a>-->
			<?php } ?>
			<?php if($att['Attachment']['id']){ ?>
			<div style="margin-top:10px;border:1px solid #EEE;">
				<canvas id="baseImg" width="618px" height="475px" />
			</div>
			<?php }?>
		</div>
	</div>
	<div class="span4">
		<div class="well" style="padding: 8px 0; margin-top:8px;">
			<ul id="masklist" class="nav nav-list">
				<li id="maskhead" class="nav-header"><?php echo __('MASK'); ?></li>
                <li id="maskfoot"></li>
			</ul>
		</div>
	</div>
</div>
<div class="row">
    <div class="span12">
        <?php echo $this->Form->submit(__('Next Page'));?>
    </div>
</div>
<?php echo $this->BootstrapForm->end();?>
<script type="text/javascript">
var baseCanvas,baseCtx,baseImg,isbaseImgLoad=false,exp;
var outCanvas,outCtx;
var mode=0;
var isCatchRect=false;
var maskCount=0;

$(function(){
    
    outCanvas = document.createElement('canvas');
    outCtx = outCanvas.getContext('2d');

    baseCanvas = document.getElementById('baseImg');
    baseCtx = baseCanvas.getContext('2d');


    baseImg = new Image();
    baseImg.src = "/files/attachment/file/<?php echo $att['Attachment']['id']; ?>/<?php echo $att['Attachment']['file']; ?>";
    baseImg.onload = function() {
        var wPar = baseCanvas.width/baseImg.naturalWidth;
        var hPar = baseCanvas.height/baseImg.naturalHeight;
        if(wPar>hPar) exp=hPar;
        else exp=wPar;

    	baseCanvas.width=baseImg.naturalWidth*exp;
		baseCanvas.height=baseImg.naturalHeight*exp;


        isbaseImgLoad=true;
        drawImage();
    }
    baseCanvas.onmousemove=function(e){
        if(mode==0){
            if(isCatchRect){
                adjustXY(e);
                
                var r=10;
                
                baseCtx.beginPath();
                baseCtx.fillStyle = "#aaa";
                baseCtx.strokeStyle = "#999";
                baseCtx.arc(mouseX, mouseY, r, 0 , Math.PI / 180, true);
                baseCtx.fill();
                baseCtx.stroke();
                
                if(drawMaxX==-1 || drawMaxX<mouseX) drawMaxX=mouseX;
                if(drawMaxY==-1 || drawMaxY<mouseY) drawMaxY=mouseY;
                if(drawMinX==-1 || drawMinX>mouseX) drawMinX=mouseX;
                if(drawMinY==-1 || drawMinY>mouseY) drawMinY=mouseY;
                
                e.preventDefault();
            }
        }
    }
    baseCanvas.onmousedown=function(e){
        if(mode==0){
            isCatchRect=true;
            drawImage();
            drawMaxX=-1;
            drawMaxY=-1;
            drawMinX=-1;
            drawMinY=-1;
        }
    }
    baseCanvas.onmouseup=function(e){
        if(mode==0){
            isCatchRect=false;
            drawImage();
            if(drawMinX!=-1){
                var r=10;
                var x=drawMinX-r;
                var y=drawMinY-r;
                var w=(drawMaxX-drawMinX)+r*2;
                var h=(drawMaxY-drawMinY)+r*2;
                
                outCanvas.width=w;
                outCanvas.height=h;
                
                outCtx.clearRect(0, 0, outCanvas.width, outCanvas.height);
                outCtx.scale(exp, exp);
                outCtx.drawImage(baseImg,-1*x/exp,-1*y/exp);
                outCtx.scale( 1/exp, 1/exp);             
                

                $("#maskfoot").before('<div class="ta" style="margin-bottom:10px"><img src="'+outCanvas.toDataURL()+'" width="150px" />&nbsp;<button class="btn btn-danger" type="button" onclick="$(this).parent().remove()">Delete</button><input type="hidden" name="data[Mask]['+maskCount+'][x]" class="tax" value="'+getNum(x,baseCanvas.width)+'"/><input type="hidden" name="data[Mask]['+maskCount+'][y]" class="tay" value="'+getNum(y,baseCanvas.height)+'"/><input type="hidden" name="data[Mask]['+maskCount+'][width]" class="taw" value="'+getNum(w,baseCanvas.width)+'"/><input type="hidden" name="data[Mask]['+maskCount+'][height]" class="tah" value="'+getNum(h,baseCanvas.height)+'"/></div>');
                
                maskCount++;
            }
            
        }
    }
    baseCanvas.onmouseout=function(e){
        isCatchRect=false;
        drawImage();
    }
    function getNum(num,base){
        var par = Math.floor((num/base)*10000)/100;
        return par<0?0:par>100?100:par;
        //return num;
    }

});

function drawImage() {
    if(isbaseImgLoad){
        baseCtx.clearRect(0, 0, baseCanvas.width, baseCanvas.height);
        baseCtx.scale(exp, exp);
        baseCtx.drawImage(baseImg,0,0);
        baseCtx.scale( 1/exp, 1/exp);             
    }
}
function adjustXY(e) {
    var rect = e.target.getBoundingClientRect();
    mouseX = e.clientX - rect.left;
    mouseY = e.clientY - rect.top;
}
</script>
