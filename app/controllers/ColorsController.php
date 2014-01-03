<?php

use Larabooster\ColorRepositoryInterface;

class ColorsController extends BaseController {
    
    protected $color;

    public function __construct(ColorRepositoryInterface $color)
    {
        $this->color = $color;
    }

    public function store()
    {

        $errors = [
            'errors' => 'VALIDATION_FAIL',
            'msg' => ''
        ];

        if (Input::has('name') && Input::has('code'))
        {
            $code = Input::get('code');
            $name = Input::get('name');
            if (!is_hexadecimal($code))
            {
                $errors['msg'] = "Mysql color ADD - {$code} is not hexadecimal";
                return Response::json($errors, 400);
            }
            $this->color->add($code, $name);
            return Response::json([ 'code' => $code , $name => $name ], 200);
        }
        $errors['msg'] = 'Mysql color ADD - Errors';
        return Response::json($errors, 400);
    }
}