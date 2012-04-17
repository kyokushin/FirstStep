<?php
 
//前にアップロードされた写真のファイル名
@$postPhotoName = $_POST["postPhotoName"];
 
//古いファイルの削除
if($postPhotoName){
 
    unlink("./img/".$postPhotoName);
    unlink("./img/thumb-".$postPhotoName);
}
 
$result = false;
 
if($_FILES['img']['name'] == "") {
    die("ファイルがないぜよ。");
 
}else{
    //アップロードされたファイルの情報を取得
    $fileName = basename(date("U")."-".$_FILES['img']['name']);
    $fileType = $_FILES['img']['type'];
    $fileTmpName = $_FILES['img']['tmp_name'];
 
    if(!preg_match("/jpeg/",$fileType)){
 
        unlink($fileTmpName);
        die( "jpegじゃないぜよ。");
 
    }else{
        //ファイルの保存
        if (!move_uploaded_file($fileTmpName, './img/' . $fileName)) {
 
            die('保存にしっぱいしたぜよ。');
 
        } else {
 
            //サムネイル作成
            include('class.image.php');
            list($width, $height, $type, $attr) = getimagesize('img/'.$fileName);
 
            $thumb = new Image('img/'.$fileName);
            $thumb->name('thumb-'.basename($fileName,".jpg"));
 
            if($width>$height){
                if($width > 100) $thumb->width(100);
            }else{
                if($height > 100) $thumb->height(100);
            }
 
            $thumb->save();
            $result = true;
        }
 
    }
 
}
 
if($result == true){
?>
<img src="<?php echo './img/thumb-'.$fileName;?>" target="<?php echo './img/'.$fileName;?>">
<input type="hidden" value="<?php echo $fileName?>" name="postPhotoName" id="postPhotoName">
<?php
}