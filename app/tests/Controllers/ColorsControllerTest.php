<?php

class ColorsControllerTest extends TestCase
{
  public function setUp()
  {
    parent::setUp();
    Eloquent::unguard();
  }

  public function tearDown()
  {
    Mockery::close();
  }

  protected function _mockColorRepository()
  {
    $colorRepo = Mockery::Mock('Larabooster\Repositories\DbColorRepository');
    return $colorRepo;
  }

  protected function _mockColorValidator()
  {
    $mockValidator = Mockery::Mock('Larabooster\Validators\ColorValidator');
    return $mockValidator;
  }

  public function test_get_all_colors()
  {
    $colorRepo     = $this->_mockColorRepository();
    $mockValidator = $this->_mockColorValidator();
    $controller    = new ColorsController($colorRepo, $mockValidator);

    $colorRepo->shouldReceive('getAll')
              ->once()
              ->andReturn(['a','b','c']);

    $colorRepo->shouldReceive('total')
              ->once()
              ->andReturn(3);

    $data = $controller->getAll();
    $this->assertEquals($data->getStatusCode(), 200);
  }

  public function test_add_color_success()
  {
    $colorRepo     = $this->_mockColorRepository();
    $mockValidator = $this->_mockColorValidator();
    $controller    = new ColorsController($colorRepo, $mockValidator);

    $mockValidator->shouldReceive('validates')->once()->andReturn(true);
    $colorRepo->shouldReceive('add')->once();

    $data = $controller->store();
    $this->assertEquals($data->getStatusCode(), 204);
  }

  public function test_add_color_failure()
  {
    $colorRepo     = $this->_mockColorRepository();
    $mockValidator = $this->_mockColorValidator();
    $controller    = new ColorsController($colorRepo, $mockValidator);
    $mockValidator->shouldReceive('validates')->once()->andReturn(false);
    $mockValidator->shouldReceive('getError')->once()->andReturn("error");

    $data = $controller->store();
    $response = json_decode($data->getContent());

    $this->assertEquals($data->getStatusCode(), 400);
    $this->assertEquals($response->msg, "error");
    $this->assertEquals($response->error, "VALIDATION_FAILED");
  }

  public function test_remove_color_success()
  {
    $colorRepo     = $this->_mockColorRepository();
    $mockValidator = $this->_mockColorValidator();
    $controller    = new ColorsController($colorRepo, $mockValidator);
    Input::replace(['code' => '#FFFFFF']);

    $colorRepo->shouldReceive('delete')->once();

    $data = $controller->delete();
    $this->assertEquals($data->getStatusCode(), 204);
  }

  public function test_remove_color_failure()
  {
    $colorRepo     = $this->_mockColorRepository();
    $mockValidator = $this->_mockColorValidator();
    $controller    = new ColorsController($colorRepo, $mockValidator);

    Input::replace(['color' => '#FFFFFF']);

    $errors = [
      'error' => 'VALIDATION_FAILED',
      'msg'   => 'You should pass a code to be able to delete a color.'
    ];
    $colorRepo->shouldReceive('delete')->never();

    $data     = $controller->delete();
    $response = json_decode($data->getContent());

    $this->assertEquals($response->error, "VALIDATION_FAILED");
    $this->assertEquals($response->msg, "You should pass a code to be able to delete a color.");
    $this->assertEquals($data->getStatusCode(), 400);
  }
}