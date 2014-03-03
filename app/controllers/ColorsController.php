<?php

function is_hexadecimal($color)
{
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

use Larabooster\Repositories\ColorRepositoryInterface;

class ColorsController extends BaseController {

    protected $color;

    public function __construct(ColorRepositoryInterface $color)
    {
        $this->color = $color;
    }

    public function getAll($limit = null)
    {
        return $this->color->getAll($limit);
    }

    public function store()
    {
        $errors = [
            'errors' => 'VALIDATION_FAIL',
            'msg' => ''
        ];

        if (Input::has('code'))
        {
            $code = Input::get('code');
            if (!is_hexadecimal($code))
            {
                $errors['msg'] = "color '{$code}' is not hexadecimal";
                return Response::json($errors, 400);
            }
            if ($this->color->exists($code))
            {
                $errors['msg'] = "color '{$code}' already exists in this storage!";
                return Response::json($errors, 400);
            }

            $this->color->add($code);
            return Response::json(null, 204);
        }
        $errors['msg'] = 'Please fill the color input';
        return Response::json($errors, 400);
    }

    public function delete()
    {
        if (Input::has('code'))
        {
            $this->color->delete(Input::get('code'));
            return Response::json(null, 204);
        }

        $errors = [
            'errors' => 'VALIDATION_FAIL',
            'msg'    => 'You should pass a code to be able to delete a color.'
        ];

        return Response::json($errors, 400);

    }
}