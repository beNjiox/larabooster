<?php namespace Larabooster;

interface ColorRepositoryInterface
{
    /**
     * check if the color is already in the storage
     * @param  string $code the color to add      
     * @return boolean       true if already exists
     */
    public function exists($code);

    /**
     * add a color
     * color are unique
     * color are in hexadecimal with the "#" (i.e: #aaafff)
     * @param [type] $code [description]
     * @param [type] $name [description]
     */
    public function add($code);

    /**
     * return an array of colors
     * @param  [type] $limit [description]
     * @return array        
     */
    public function getAll($limit = 10);
}
