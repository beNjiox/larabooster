<?php

class ColorValidatorTest extends TestCase {

  public function setUp()
  {
    parent::setUp();
    Eloquent::unguard();
  }

  public function tearDown()
  {
    Mockery::close();
  }

  protected function _mockColorValidator()
  {
    $mockValidator = Mockery::Mock('Larabooster\Validators\ColorValidator');
    return $mockValidator;
  }

  public function test_valid_color_success()
  {
    $colorRepo = $this->_mockColorRepository();
    $colorValidator = new Larabooster\Validators\ColorValidator($colorRepo);
    $colorRepo->shouldReceive('exists')->once()->andReturn(false);

    $ret = $colorValidator->validates(['code' => '#FFFFFF']);

    $this->assertTrue($ret);
  }

  public function test_valid_color_fail_color_already_exist()
  {
    $colorRepo = $this->_mockColorRepository();
    $colorValidator = new Larabooster\Validators\ColorValidator($colorRepo);
    $colorRepo->shouldReceive('exists')->once()->andReturn(true);

    $ret = $colorValidator->validates(['code' => '#FFFFFF']);

    $this->assertFalse($ret);
    $this->assertEquals($colorValidator->getError(), "color '#FFFFFF' already exists in this storage!");
  }

  public function test_valid_color_fail_color_not_hexadecimal()
  {
    $colorRepo = $this->_mockColorRepository();
    $colorValidator = new Larabooster\Validators\ColorValidator($colorRepo);

    $ret = $colorValidator->validates(['code' => 'not_hexa']);

    $this->assertFalse($ret);
    $this->assertEquals($colorValidator->getError(), "color 'not_hexa' is not hexadecimal");
  }

  public function test_valid_color_fail_color_not_passed_as_argument()
  {
    $colorRepo = $this->_mockColorRepository();
    $colorValidator = new Larabooster\Validators\ColorValidator($colorRepo);

    $ret = $colorValidator->validates(['color' => 'wrongParam']);

    $this->assertFalse($ret);
    $this->assertEquals($colorValidator->getError(), "Please fill the color input");
  }
}