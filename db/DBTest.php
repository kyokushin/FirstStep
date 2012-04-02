<?php

require_once("PHPUnit/Framework.php");
require_once("db_functions.php");

class DBTest extends PHPUnit_Framework_TestCase
{

	private $plDB;

	public function setUp()
	{
		$this->plDB = new MusicPlayListDB();
		$this->plDB->open();
	}


	public function testSaveObject()
	{
		$user["name"] = "test_user";
		$user["icon_path"] = "NULL";
		$user["pass"] = "password";

		$this->plDB->addNewUser( $user["name"], $user["icon_path"], $user["pass"] );
		$result = $this->plDB->getUserId( $user["name"] );
		$user_id = $result["id"];
		$this->assertTrue(!empty($user_id));
		
		$playlist["user_id"] = $user_id;
		$playlist["title"] = "title";
		$playlist["comment"] = "comment";
		$playlist["genre"] = "genre";

		$this->plDB->addNewPlayList( $playlist["user_id"], $playlist["title"], $playlist["comment"], $playlist["genre"] );

		$this->plDB->getPlayListWithUserId( $user_id );
	}

}

?>
