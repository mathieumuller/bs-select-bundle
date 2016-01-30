<?php
namespace Axiolab\BootstrapSelectBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BootstrapSelectChoiceTypeExtension extends AbstractTypeExtension
{
    private $bundleParameters;

    public function __construct($bundleParameters)
    {
        $this->bundleParameters = $bundleParameters;
    }
    public function getExtendedType()
    {
        return 'choice';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefined(
            [
                'selectpicker'
            ]
        );

        $resolver->setDefaults(
            [
                'selectpicker' => [
                    'multiselect' => [
                        'enabled'              => false,
                        'max_options'          => false,
                        'selected_text_format' => false,
                    ],
                    'live_search' => [
                        'enabled'  => false,
                        'ajax'     => false,
                        'route'    => false,
                        'operator' => 'contains', //contains, begins, ends
                        'property' => false
                    ],
                    'placeholder' => false,
                    'style'       => false,
                    'width'       => false,
                    'subtext'     => false,
                    'keywords'    => false,
                    'show_tick'   => $this->bundleParameters['show_tick'],
                    'max_size'    => false
                ]
            ]
        );
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['selectpicker'] = $options['selectpicker'];
    }
}