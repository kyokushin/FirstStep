<?php

class MusicPlayListDB {

	private $DB = "music_play_list";
	private $userTable = "user";
	private $playListTable = "play_list";
	private $playListItemTable = "play_list_item";
	private $musicTable = "music";
	private $commentTable = "comment";
	private $db_link;

	private function dq( $str )
	{
		return '"'.$str.'"';
	}

	//汎用的なテーブルへの挿入関数。
	//table_nameはテーブル名
	//paramsにはキーをカラム名とした連想配列を代入する
	private function insertTable( $table_name, $params )
	{
		$prefix = "insert into $table_name (";
		$suffix = " ) values (";
		$size = count( $params );
		$count = 0;
		foreach( $params as $key => $value ){
			$prefix .= $key;
			$suffix .= $value;
			if( $count != $size-1 ){
				$prefix .= ",";
				$suffix .= ",";
			}
			$count++;
		}

		$query = $prefix.$suffix.")";
		$result = mysql_query( $query, $this->db_link );
		if( !$result ){
			die("invalid query at ".__LINE__." in ".__FILE__.": ".mysql_error() );
		}
	}

	//汎用的なテーブルのアップデート関数。
	//table_nameにはテーブル名を。
	//paramsにはキーをカラム名とした連想配列を。
	//suffixには条件を（例：where id = 1）
	private function updateTable( $table_name, $params, $suffix )
	{
		if( $suffix == NULL )
			die("empty suffix");

		$prefix = "update $table_name set ";
		$size = count( $params );
		$count = 0;
		foreach( $params as $key=>$value ){
			$prefix .= $key."=".$value;
			if( $size != $count-1 ){
				$prefix .= ",";
			}
			$count++;
		}
		$query = $prefix.$suffix;
		$result = mysql_query($query, $db_link);
		if( !$result ){
			die("invalid query: ".mysql_error());
		}

	}
	
	// データベースへの接続
	public function open()
	{
		$this->db_link = mysql_connect('localhost', 'takuma', 'takuma');
		if( empty($this->db_link)){
			die("failed to connect db at ".__LINE__." in ".__FILE__." ".mysql_error());
		}
		if( !mysql_select_db( $this->DB, $this->db_link )){
			die("failed to select $this->DB. ".$mysql_error());
		}

	}

	//データベースとの接続切断
	public function close()
	{
		mysql_close($this->db_link);
	}

	// user_idを指定することでuser_idの持っている
	// Playlistをすべて受け取る。
	public function getPlayListWithUserId( $user_id )
	{
		$query = "select * from ".$this->playListTable
			." where ".$this->playListTable.".user_id = $user_id";

		$ret = mysql_query( $query, $this->db_link  );
		if( !$ret ){
			die("invalid query: ".mysql_error());
		}
		$result = mysql_fetch_assoc( $ret );
		if( $result == 0){
			die("failed to select play list: ".mysql_error());
		}
		return $result;
	}

	// user_nameが持っているプレイリストを配列として受け取る。
	public function getPlayListWithUserName($user_name )
	{
		$query = "select * from ".$this->playListTable
			." where $this->userTable.name = $user_name and"
			.$this->playListTable.".user_id = $this->userTable".id;

		if( !$ret ){
			die("invalid query: ".mysql_error());
		}
		$result = mysql_fetch_assoc( $result );
		if( $result == 0){
			die("failed to select play list: ".mysql_error());
		}
		return $result;
	}

	//登録されているプレイリストを取得する。
	public function getPlayList( $play_list_id )
	{
		$query = "select * from "
			.$this->playListTable.", "
			.$this->playListItemTable.", "
			.$this->musicTable
			." where "
			.$this->playListTable.".id == ".$play_list_id." and "
			.$this->playListTable.".id == "
			.$this->playListItemTable.".play_list_id and "
			.$this->playListItemTable.".music_id == "
			.$this->musicTable.".id order by "
			.$this->playListItemTeble.".order_number";

		$ret = mysql_query( $query, $this->db_link );
		if( !$ret ){
			die("invalid query: ".mysql_error());
		}

		$result = mysql_fetch_assoc( $ret );
		if( $result == 0){
			die("failed to select play list: ".mysql_error());
		}
		return $result;
	}

	// 新しいプレイリストを登録する。
	// 戻り値はプレイリストの登録ID。
	// これをプレイリストアイテムの追加に利用する。
	public function addNewPlayList( $user_id, 
		$title, $comment, $genre)
	{
		$params = array();
		$params["user_id"] = $this->dq($user_id);
		$params["title"] = $this->dq($title);
		$params["user_comment"] = $this->dq($comment);
		$params["genre"] = $this->dq($genre);
		$params["created_date_time"] = 'now()';

		$this->insertTable( $this->playListTable, $params);

		return mysql_insert_id();
	}

	// 新しいプレイリストにアイテムを追加する。
	public function addNewPlayListItem( 
		$play_list_id, $music_id, $order_number,
		$sinc, $bpm, $genre, $in_out, $comment)
	{
		$params = array();
		$params["play_list_id"] = '"'.$play_list_id.'"';
		$params["music_id"] = $this->dq($music_id);
		$params["order_number"] = $order_number;
		$params["sinc"] = $sinc;
		$params["bpm"] = $bpm;
		$params["genre"] = $this->dq($genre);
		$params["in_out"] = $in_out;
		$params["comment"] = $this->dq($comment);

		$this->insertTable( $this->playListItemTable, $params );
	}

	//登録されているプレイリストを更新する
	public function updatePlayList( $id, $title,
		$user_comment, $genre)
	{
		$params = array();
		$params["title"] = '"'.$title.'"';
		$params["user_comment"] = '"'.$user_comment.'"';
		$params["genre"] = '"'.$genre.'"';
		$params["last_access_date_time"] = 'now()';

		updateTable( $this->playListTable, $params, "where id = $id");
	}

	// 登録されているプレイリストアイテムを更新する。
	// アイテムはプレイリストIDと順番(order_number)で特定する。
	public function updatePlayListItem( 
		$play_list_id, $order_number, $music_id,
		$sinc, $bpm, $genre, $in_out, $comment)
	{
		$play_list_id = $this->dq($play_list_id);
		$music_id = $this->dq($music_id);
		$order_number = $order_number;

		$params = array();
		$params["music_id"] = $music_id;
		$params["sinc"] = $sinc;
		$params["bpm"] = $bpm;
		$params["genre"] = $this->dq($genre);
		$params["in_out"] = $in_out;
		$params["comment"] = $this->dq($comment);

		updateTable( $this->playListItemTable, $params, "where play_list_id = $play_list_id and order_number = $order_number");
	}

	// プレイリストアイテムを削除する。
	// アイテムはプレイリストIDと順番(order_number)で特定する。
	// 注意：このメソッドは削除だけで順番の修正は行わない。
	// 　　　順番の修正はfixPlayListItemOrderを使うこと
	public function deletePlayListItem( 
		$play_list_id, $order_number)
	{
		$query = "delete from ".$this->playListItemTable
			." where play_list_id = ".$play_list_id
			." and music_id = ".$music_id
			." and order_number = ".$order_number;

		$result = mysql_query($query, $this->db_link);
		if( !$result ){
			die("invalid query: ".mysql_error());
		}
	}

	// プレイリスト中のアイテムの順番を修正する。
	// deletePlayListItemで削除されたことで飛び飛びになってしまった
	// order_numberを連番に修正するために利用することを想定している。
	public function fixPlayListItemOrder( 
		$play_list_id )
	{
		$query = "set @i := 0;"
			."update ".$this->playListItemTable
			." set order_number = (@i := @i + 1)"
			." where play_list_id = ".$play_list_id
			." order by order_number";
		$result = mysql_query( $query, $this->db_link );
		if( !$result ){
			die( "invalid query: ".mysql_error() );
		}
	}

	//MUSICの追加
	public function addNewMusic( $song_name,
		$artist_name, $url)
	{
		$params = array();
		$params["songname"] = '"'.$song_name.'"';
		$params["artist_name"] = '"'.$artist_name.'"';
		$params["url"] = '"'.$url.'"';

		$this->insertTable( $this->musicTable, $params);

	}

	//ユーザーの追加
	public function addNewUser( $name, $icon_path, $password)
	{
		$params["name"] = '"'.$name.'"';
		$params["icon_path"] = '"'.$icon_path.'"';
		$params["password"] = '"'.$password.'"';
		$params["created_date_time"] = 'now()';
		$params["last_login_date_time"] = 'now()';

		$this->insertTable( $this->userTable, $params);
	}

	//ユーザーIDの取得
	public function getUserId( $name )
	{
		$query = "select id from user where name = \"$name\"";

		$ret = mysql_query( $query, $this->db_link );
		if( !$ret ){
			die("invalid query at ".__LINE__." in ".__FILE__.": ".mysql_error());
		}

		$result = mysql_fetch_assoc( $ret );
		if( $result == 0){
			die("failed to select play list: ".mysql_error());
		}
		return $result;
	}
}
?>
