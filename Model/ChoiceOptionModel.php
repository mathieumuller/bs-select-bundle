<?php
namespace AxioLab\BootstrapSelectBundle\Model;

class ChoiceOptionModel
{
    public $value;
    public $label;
    public $subtext;
    public $keyWords;

    public function __construct($value, $label, $subtext, $keyWords)
    {
        $this->value    = $value;
        $this->label    = $label;
        $this->subtext  = $subtext;
        $this->keyWords = $keyWords;
    }
}
