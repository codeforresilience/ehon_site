var baseCanvas,baseCtx,baseImg,isbaseImgLoad=false,exp;
var outCanvas,outCtx;
var drawMaxX=-1,drawMaxY=-1,drawMinX=-1,drawMinY=-1;
var isCatchRect=false;

var mode=0;

var saveObj=[];

var pageImagePath="";

$(function(){
    $(".section2").hide();
    $("select",".section1").hide();
    
    $("#tolang").change(function(e){
        $("textarea",".section2").val("");
    });

    baseCanvas = document.getElementById('baseImg');
    baseCtx = baseCanvas.getContext('2d');
    
    outCanvas = document.createElement('canvas');
    outCtx = outCanvas.getContext('2d');
    
    baseImg = new Image();
    baseImg.src = "image/ehon2_08.jpg";
    baseImg.onload = function() {
        var wPar = baseCanvas.width/baseImg.naturalWidth;
        var hPar = baseCanvas.height/baseImg.naturalHeight;
        if(wPar>hPar) exp=hPar;
        else exp=wPar;
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
                
                $("#targetArea").prepend('<div class="ta"><div class="cap"><img src="'+outCanvas.toDataURL()+'" /><div class="overlay"><button class="btn btn-mini btn-danger" type="button" onclick="deleteTarget(this)">Delete</button></div></div><div class="section1"><textarea rows="4" class="fromtext input-xlarge"></textarea><div class="frompre"></div></div><div class="section2"><i class="icon-circle-arrow-right"></i><textarea rows="4" class="totext input-xlarge"></textarea></div><input type="hidden" class="tax" value="'+getNum(x,baseCanvas.width)+'"/><input type="hidden" class="tay" value="'+getNum(y,baseCanvas.height)+'"/><input type="hidden" class="taw" value="'+getNum(w,baseCanvas.width)+'"/><input type="hidden" class="tah" value="'+getNum(h,baseCanvas.height)+'"/><div class="clear"/></div>');
                
                $(".section2").hide();

            }
            
        }
    }
    baseCanvas.onmouseout=function(e){
        isCatchRect=false;
        drawImage();
    }
    function getNum(num,base){
        //var par = Math.floor((num/base)*10000)/100;
        //return par<0?0:par>100?100:par;
        return num;
    }
});



function deleteTarget(t){
    console.log($(t).parent().parent().parent().get(0));
    $(t).parent().parent().parent().remove();
}

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

function previewPage(){
    /*
    var ps={url:"xxxxxx.png",script:[]};
    $("#targetArea .ta").each(function(e){
        var one={x:$(".tax",this).val(),y:$(".tay",this).val(),width:$(".taw",this).val(),height:$(".tah",this).val()};
        one["text"]=($(".totext",this).val()).split('"').join('¥"');
        ps["script"].push(one);
    });
    console.log(ps); 
    $.ajax({
        url: "preview.txt",
        type: "GET",
        data: ps,
        dataType: "text"
    }).done(function(data){    
        $("#prevImg").attr("src",data);
        $("#lightbox").css("top",(document.documentElement.scrollTop || document.body.scrollTop)-100);
        $("#lightbox").show();
    }).fail(function(data){
        alert('image load error!!!');
    });
    */

    
    console.log(baseImg);
    var prevCanvas = document.createElement('canvas');
    var prevCtx = prevCanvas.getContext('2d');
    prevCanvas.width=baseCanvas.width;
    prevCanvas.height=baseCanvas.height;
    prevCtx.clearRect(0, 0, baseCanvas.width, baseCanvas.height);
    prevCtx.scale(exp, exp);
    prevCtx.drawImage(baseImg,0,0);
    prevCtx.scale( 1/exp, 1/exp);  

    prevCtx.font = "18px bold sans-serif";
    $("#targetArea .ta").each(function(e){
        prevCtx.fillStyle = "#FFFFFF";
        prevCtx.beginPath();
        prevCtx.fillRect($(".tax",this).val(), $(".tay",this).val(), $(".taw",this).val(), $(".tah",this).val());
        prevCtx.fillStyle = "black";
        var ar=multilineText(prevCtx,$(".totext",this).val(),$(".taw",this).val());
        console.log($(".tay",this).val());
        for(i = 0; i < ar.length; i++){
    	   prevCtx.fillText( ar[ i ], $(".tax",this).val(), Number($(".tay",this).val())+( (i+1) * 20) );
        }
    });
    
        $("#prevImg").attr("src",prevCanvas.toDataURL());
        $("#lightbox").css("left",10);
        $("#lightbox").css("top",700);
        $("#lightbox").show();
    
}

function tabsEv(num){
    var i=0;
    $("li","#tabsArea").each(function(){
        if(i==num){
            $(this).addClass("active");
        }else{
            $(this).removeClass("active");            
        }
        i++;
    });
    if(num==0){
        mode=0;
        $(".cap").show();
        $("textarea",".section1").show();
        $(".section2").hide();
        $("#targetArea .ta").each(function(e){
            $(".frompre",this).html("");
        });
        $("select",".section1").hide();
    }else{
        mode=1;
        $(".cap").hide();
        $("textarea",".section1").hide();
        $(".section2").show();
        $("#targetArea .ta").each(function(e){
            var t=$(".fromtext",this).val();
            if(!t || t=="")t="&nbsp;";
            $(".frompre",this).html(t);
        });
        $("select",".section1").show();
    }
    
    
    return false;
}
    
function multilineText(context, text, width) {
    var len = text.length; 
    var strArray = [];
    var tmp = "";
    var i = 0;

    if( len < 1 ){
        //textの文字数が0だったら終わり
        return strArray;
    }

    for( i = 0; i < len; i++ ){
        var c = text.charAt(i);  //textから１文字抽出
        if( c == "\n" ){
            /* 改行コードの場合はそれまでの文字列を配列にセット */
            strArray.push( tmp );
            tmp = "";

            continue;
        }

        /* contextの現在のフォントスタイルで描画したときの長さを取得 */
        if (context.measureText( tmp + c ).width <= width){
            /* 指定幅を超えるまでは文字列を繋げていく */
            tmp += c;
        }else{
            /* 超えたら、それまでの文字列を配列にセット */
            strArray.push( tmp );
            tmp = c;
        }
    }

    /* 繋げたままの分があれば回収 */
    if( tmp.length > 0 )
        strArray.push( tmp );

    return strArray;
}

