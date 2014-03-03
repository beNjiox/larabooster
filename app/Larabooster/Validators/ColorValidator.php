<?php namespace Larabooster\Validators;

use Larabooster\Repositories\ColorRepositoryInterface;
use Response;

class ColorValidator {

  private $err = "";

  private function is_hexadecimal($color)
  {
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
  }

  public function __construct(ColorRepositoryInterface $color)
  {
    $this->color = $color;
  }

  public function setError($err)
  {
    $this->err = $err;
  }

  public function getError()
  {
    return $this->err;
  }

  public function validates($colorInput)
  {
    if (isset($colorInput['code']))
    {
      $code = $colorInput['code'];

      if (!$this->is_hexadecimal($code))
      {
        $this->setError("color '{$code}' is not hexadecimal");
        return false;
      }

      if ($this->color->exists($code))
      {
        $this->setError("color '{$code}' already exists in this storage!");
        return false;
      }

      return true;
    }

    $this->setError('Please fill the color input');
    return false;
  }
}