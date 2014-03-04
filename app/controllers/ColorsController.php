<?php

use Larabooster\Repositories\ColorRepositoryInterface;
use Larabooster\Validators\ColorValidator;
use Config;

class ColorsController extends BaseController {

  protected $color;
  protected $validator;

  public function __construct(ColorRepositoryInterface $color, ColorValidator $validator)
  {
    $this->color     = $color;
    $this->validator = $validator;
  }

  public function getAll()
  {
    $page = 1;
    $rpp  = Config::get('app.RESULT_PER_PAGE');

    if (Input::has('page')) $page = Input::get('page') - 1;

    $data                                = [];
    $data['data']                        = $this->color->getAll($page, $rpp);
    $data['metadata']['total']           = (int) $this->color->total();
    $data['metadata']['page']            = (int) $page;
    $data['metadata']['result_per_page'] = (int) $rpp;
    $data['metadata']['nb_pages']        = (int) ceil( ( $data['metadata']['total'] / $data['metadata']['result_per_page'] ) );

    return $data;
  }

  public function store()
  {
    if ( ! $this->validator->validates(Input::all()))
    {
      return Response::json([
        'error' => 'VALIDATION_FAILED',
        'msg'   => $this->validator->getError()
      ], 400);
    }

    $this->color->add(Input::get('code'));
    return Response::json(null, 204);
  }

  public function delete()
  {
    if (Input::has('code'))
    {
      $this->color->delete(Input::get('code'));
      return Response::json(null, 204);
    }

    $errors = [
      'error' => 'VALIDATION_FAIL',
      'msg'   => 'You should pass a code to be able to delete a color.'
    ];

    return Response::json($errors, 400);
  }
}