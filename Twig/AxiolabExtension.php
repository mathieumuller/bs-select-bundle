<?php

namespace Axiolab\BootstrapSelectBundle\Twig;

class AxiolabEtension extends \Twig_Extension
{
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('unsetIndex', [$this, 'unsetIndex']),
        ];
    }

    public function unsetIndex(array $array, $idx)
    {
        unset($array[$idx]);

        return $array;
    }

    public function getName()
    {
        return 'axiolab_extension';
    }
}
