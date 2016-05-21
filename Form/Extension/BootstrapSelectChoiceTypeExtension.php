<?php
namespace Axiolab\BootstrapSelectBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BootstrapSelectChoiceTypeExtension extends AbstractTypeExtension
{
    private $bundleParameters;

    public function __construct($bundleParameters)
    {
        $this->bundleParameters = $bundleParameters;
        $this->options          = [];
    }

    public function getExtendedType()
    {
        return ChoiceType::class;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefined(
            [
                'selectpicker'
            ]
        );
        $this->options = [
            'selectpicker' => [
                'multiselect' => [
                    'enabled'              =>false,
                    'max_options'          => false,
                    'selected_text_format' => false,
                ],
                'live_search' => [
                    'enabled'  => false,
                    'ajax'     => false,
                ],
                'placeholder' => false,
                'style'       => false,
                'width'       => false,
                'subtext'     => false,
                'keywords'    => false,
                'show_tick'   => $this->bundleParameters['show_tick'],
                'search_start' => $this->bundleParameters['search_start'],
                'max_size'    => false
            ]
        ];

        $resolver->setDefaults($this->options);
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['selectpicker'] = array_replace($this->options['selectpicker'], $options['selectpicker']);
    }
}
