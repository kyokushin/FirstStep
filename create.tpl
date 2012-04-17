	<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"
	"http://www.w3.org/TR/html4/strict.dtd">

	<html lang="en">
	  <head>
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	    <!-- Framework CSS -->
	    <link rel="stylesheet" href="css/blueprint/screen.css" type="text/css" media="screen, projection">
	    <link rel="stylesheet" href="css/blueprint/print.css" type="text/css" media="print">
	     <link rel="stylesheet" href="css/Create.css" type="text/css" media="screen">
	    <!--[if lt IE 8]><link rel="stylesheet" href="../../blueprint/ie.css" type="text/css" media="screen, projection"><![endif]-->
	 <!-- jquery script -->
      {literal}
    <script src="js/jquery.js"></script>
    <script src="js/imagePreview.js"></script>
    <script src="js/jquery.upload.js"></script>
    <script type="text/javascript">
  <!--
	// フォームの複製を行う関数を定義
	var copy_block = function(i) {
		var increament_id = function(name,id) {
			$("#cover"+id+" ."+name).attr("id", name+id).attr("name", name+id);
		};
		var Placetarget = $("#cover"+(i-1));
		var target = $("#cover1");
		target.clone().insertAfter(Placetarget).attr("id","cover"+i);
		increament_id("Row",i);
		increament_id("Artist",i);
		increament_id("Song",i);
		increament_id("Genre",i);
		increament_id("BPM",i);
		increament_id("Mix",i);
		increament_id("checkbox",i);
		increament_id("Comment",i);
		increament_id("delete",i);
		//tagObj = document.getElementById("Row"+i);
		//tagObj.innerText = i;
		$("#Row"+i).html(i);
        //削除ボタンが動くように見せる。
       
		$(".delete").css({cursor : "pointer", color　: "#3cf"});
		/* alert(" got focus2."+i); */
	};
	var move_block = function(id) {
		$("#Artist"+(id-1)).val($("#Artist"+ id).val());
		$("#Song"+(id-1)).val($("#Song"+ id).val());
		$("#Genre"+(id-1)).val($("#Genre"+ id).val());
		$("#BPM"+(id-1)).val($("#BPM"+ id).val());
		$("#Mix"+(id-1)).val($("#Mix"+ id).val());
		$("#checkbox"+(id-1)).val($("#checkbox"+ id).val());
		$("#Comment"+(id-1)).val($("#Comment"+ id).val());
	};

	var init_vals = function(i) {
		$("#cover"+i+" :text").val('');
		$("#cover"+i+" select").val('1');
		$("#cover"+i+" :checkbox").val('SINC');
	};
	var add_block = function(i) {
		copy_block(i);
		init_vals(i);
	};
	// イベントを設定
	$(function() {
    //送信ボタンの非表示
        $('#submit').hide();
        
    //行削除
		$("#delete1").css({cursor: "default", color: "#000"});
		$("#Add").click(function() {
			var i=1;
			while($("#cover"+i).length != 0) {
				i++;
			}
			add_block(i);
		});
        //Form send
        $("#Get").click(function() {
        //play_list が一番外
        var play_list = {};
        play_list['User'] = "DUMMY";
        play_list['UserComment'] = $('#UserComment').val();
        play_list['PLname'] = $('#PLname').val();
        play_list['PLtags'] = $('#PLtags').val();
        play_list['image']= $('.preview').find("img").attr('target');
        //Detail
        var query_list = {};
        var list = {};
        $('[id\^="cover"]').each(function(index, domEle){
        list['Artist'] = $(this).find('.Artist').val();
        list['Song'] = $(this).find('.Song').val();
        list['Genre'] = $(this).find('.Genre').val();
        list['BPM'] = $(this).find('.BPM').val();
        list['MIX'] = $(this).find(':selected').val();
        list['SINC'] = $(this).find(':checkbox').attr('checked');
        list['Comment'] = $(this).find('.Comment').val();
        query_list[index] = list;
        //alert(index);
        });
        play_list['query_list'] = query_list;
        var obj = $('form').serializeArray();
        $('<P>',{html:'<strong>serialize</strong><br />' + $.param(obj)})
        .appendTo(document.body);
        $.ajax({type:'POST',url:'echo.php?mode=init',data:obj,dataType:'json'})
        .done(function(data,statusText,jqXHR){console('送信済み');});
        });
        
		//Form Reset
		$("#reset").click(function() {
			var i=1;
			while($("#cover"+i).length != 0) {
				init_vals(i);
				i++;
			}
		});
		//Delete column
		$(".delete").live('click' ,function(){
		 var id = $(this).attr("id");// idの取得
		 id = Number(id.slice(-1));
		 var i=1;
			while($("#cover"+i).length != 0) {
				if(i>id){
					move_block(i);
				}
				i++;
			}
			if( i-1 > 1){
			$("#cover"+(i-1)).remove();
				if( i-1 == 2){
					 $(".delete").css({cursor: "default", color: "#000"});
				}
			}
         //alert(" got focus."+ (i-1));
         });

		//テキストの文字を数える。今はMax150文字
		$("textarea").keyup(function(){
	          var counter = $(this).val().length;
	        $("#countUp").text(counter);
	        if(counter == 0){
	            $("#countUp").text("0");
	        }
	        if(counter >= 150){
	            $("#countUp").css("color","red");
	        } else{$("#countUp").css("color","#666");}
	    });
//image file
         //フォームの内容が変更されたとき
    $('#img').change(function() {
        var preview = $('.preview');
 
        //現在表示されているものを消す。
        preview.find("img").fadeOut(300);
 
        //アップロード    
        $(this).upload(
            'upload.php',
            $("form").serialize(),
            function(html){
            //サムネイルの表示
                preview.html(html).animate({"height":preview.find("img").height()+"px"},300,function(){
                    preview.find("img").hide().fadeIn(300);
                    alert(preview.find("img").attr('target'));
                    preview.attr('href',preview.find("img").attr('target'));
                });
            },'html');
    });
 
    //離れるときに画像を削除
    $(window).bind("beforeunload",function(){
        var unlinkFile = $("#postPhotoName").val();
        $.ajax({
            async: false,
            cache: false,
            type:   "POST",
            url:    "upload.php",
            data:   "postPhotoName="+unlinkFile
 
        });
 
    });
        
        
        
        
        
	});
  //-->
  </script>
 {/literal}
  <title>test</title>
</head>
<body>
 <div class="container showgrid">
 <br>
      <h1>CreatePage</h1>
      <hr>
      <div class="span-24 last">
      <form id="PlayList" >
         <fieldset>
            <legend>Play List Infomation</legend>
               <div class="span-16">
              <label for="UserComment">Auther Comment</label><br>
              <textarea name="UserComment" id="UserComment" rows="7" cols="55"></textarea>
              <!--文字数表示-->
              <div id="countUp">0</div>
              </div>
              <div class="span-7 last">
              <label for="PLname">Playlist Name</label>
              <input type="text" class="title" id="PLname" name="PLname" value="">
              <label for="PLtags">Playlist Genre (for tags)</label>
              <input type="text" class="mid" id="PLtags" name="PLtags" value="">
             <br>
              <label for="Pic">Picture</label>
              <input type="file" value="" id="img" name="img" size="20" />
              <a class="preview"><div>Preview is here</div></a>
              <!-- <input type="file" name="Pic"> -->
            </div>
           </fieldset>
<div class="span-24 last">
  <fieldset>
            <legend>Play list</legend>
  			<div id="cover1" class = "cover">
              <div class="span-1">
            <b id = "Row1" class="Row">1</b>
            </div>
               <div class="span-7">
              <label for="Artist">Artist</label>
              <input type="text" class="Artist" name="Artist1" id="Artist1" value="">
              </div>
               <div class="span-7">
              <label for="Song">Song</label>
               <input type="text" class="Song" name="Song1" id="Song1" value="">
              </div>
              <div class="span-4">
              <label for="Genre">Genre</label>
              <input type="text" class="Genre" id="Genre1" name="Genre1" value="">
            </div>
            <div class="span-4 last ">
              <label for="BPM">BPM</label>
              <input type="text" class="BPM" id="BPM1" name="BPM1" value="">
            </div>
            <div class="span-1">
				<div class = "delete"  id="delete1">[X]</div>
            </div>
            <div class="span-5">
            <label for="Mix">Mix type</label>
            <select id="Mix" name="Mix1"class="Mix">
              <option value="1">Fade in Fade out</option>
              <option value="2">Fade in Cut out</option>
              <option value="3">CUT in  Fade out</option>
              <option value="4">CUT in  Cut out</option>
            </select>
             </div>
             <div class="span-2">
             <label>SINC</label><br>
              <input type="checkbox" id="checkbox" name="checkbox1" value="SINC" checked="checked" class="checkbox">
            </div>
             <div class="span-15 last ">
              <label for="Comment">Comment</label>
              <input type="text" class="Comment" id="Comment1" name="comment1" value="">
            </div><br>
  </div>
   </fieldset>
   </div>
  <hr>
 <input type="button" id="Add" value="Add" />
 <input type="button" id="Get" value="Get" />
 <input type="reset" id="reset" value="reset">
 </form>
 </div>
 </div>
</body>
</html>