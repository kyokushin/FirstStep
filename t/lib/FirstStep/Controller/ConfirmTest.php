<?php
require('FirstStep/Controller/Confirm.php');

class ConfirmTest extends PHPUnit_Framework_TestCase {
  protected $confirm_controller;
  public function setUp(){
    $this->confirm_controller = new ConfirmController();
  }

  /**
   * @test
   */
  public function is_valid_run_mode(){
    $obj = new ReflectionMethod($this->confirm_controller, 'is_valid_mode');
    $obj->setAccessible(true);
    $ret = $obj->invokeArgs($this->confirm_controller, array('odasan'));
    $this->assertFalse($ret);
  }

  /**
   * @dataProvider provide_mode_list
   */
  public function test_is_invalid_run_mode($mode) {
    $obj = new ReflectionMethod($this->confirm_controller, 'is_valid_mode');
    $obj->setAccessible(true);
    $ret = $obj->invokeArgs($this->confirm_controller, array("$mode"));
    $this->assertTrue($ret);
  }

  /**
   * @dataProvider provide_normalize_query
   */
  public function test_normalize_query($query_raw, $query_normalize){
    $obj = new ReflectionMethod($this->confirm_controller, 'normalize_query');
    $obj->setAccessible(true);
    $ret = $obj->invokeArgs($this->confirm_controller, array("$query_raw"));
    $this->assertEquals($query_normalize, $ret);
  }

  public function provide_mode_list() {
    return array(
		 array('confirm'),
		 array('finish'),
		 array('test')
		);
  }

  public function provide_normalize_query() {
    return array(
		 array('unko tinko', 'unkotinko'),
		 array('<script>alert(unko)</script>', '&lt;script&gt;alert(unko)&lt;/script&gt;')
		 );
  }
}
?>