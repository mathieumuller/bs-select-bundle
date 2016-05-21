# AXIOLAB BOOTSTRAPSELECTBUNDLE

Transform your symfony form choice and entity fields into a fully configurable bootstrap-select.

Installation
============

Add the bunde to your `composer.json` file:

```javascript
require: {
    // ...
    "axiolab/bs-select-bundle": "2.0.3"
}
```

Register the bundle with your kernel:

```php
// in AppKernel::registerBundles()
$bundles = [
    // ...
    new Axiolab\BootstrapSelectBundle\AxiolabBootstrapSelectBundle(),
    // ...
];
```

Import bootstrapselect css and javascripts:
```twig
    {# Insert the following code in the <head> section of your layout #}
    {% stylesheets 'bundles/axiolabbootstrapselect/css/bootstrap-select.css' %}
        <link rel="stylesheet" href="{{ asset_url }}" />
    {% endstylesheets %}
    
    {% javascripts 'js/axiolabbootstrapselect.js' %}
        <script type="text/javascript" src="{{ asset_url }}"></script>
    {% endjavascripts %}
```
Then install the required assets:
```shell
    ./app/console assets:install
    ./app/console assetic:dump
    ./app/console ca:cl
```
___________________

Configuration
=============

#### Minimum configuration
There are  a few parameters you can customize in your config.yml file, below is the default configuration
```yml
    axiolab_bootstrap_select:
        form_resource: "AxiolabBootstrapSelectBundle:form:bootstrapSelect.html.twig" # If you want to change the botstrapselect widget template provide your template path here
        preferred_language: "en_US" # The language for the translations * 
        show_tick: true # Displays a check icon on the selected option(s)
        search_start: 3 # If you use bootstrapselect live_search with ajax, this is the minimum characters to provide before an ajax request is launched
```
*cf [i18n](Resources/public/js/i18n) for available languages

#### Form widget configuration
    Here is the base configuration to use the bootstrapselect form type (this bundle overrides each ChoiceType and childs)
    Please look https://silviomoreto.github.io/bootstrap-select for more info
```php
    $builder->add(
        'toto', 
        EntityType::class,
        [
            'class' => 'AppBundle\Entity\Toto',
            'property' => 'tata',
            // The following options can be customized
            'selectpicker' => [
                'max_size' => 10, // The bootstrapselect only displays 10 options and a scrollbar
                'width' => '100%', 
                'placeholder' => 'search a tata for toto',
                'style' => 'btn-sm', // add the wished class to the bootstrapselect
                'subtext' => false, // Allows you to add subtext to your options
                'keywords' => false, // Allows you to add keywords to the live_search(ajax or not)
                'multiselect' => [ // Allows you to select many choices
                    'enabled' => false, //Enable/disable the multiselect
                    'max-options' => 5, // Set the maximum of selectable options
                    'selected_text_format' => "values", //See js plugin doc for more details
                ],
                'live_search' => [
                    'enabled' => true, //Enable/disable the live_search
                    'ajax' => false, //Enable/disable ajax for the live_search
                ],
            ],
            // Use the choice_attr option to dynamically set your keywords and subtext
            'choice_attr' => function($val, $key, $index) {
                return [
                    'keywords' => $val->getKeyword1() . " " . $val->getKeyword2()
                    'subtext' => $val->getSubtext()
                ];
            },
```
#### Ajax data loading
When the live_search[ajax] option is set to true, the bundle allows you to load your data through a POST ajax request on the form action route. 
The request is fetched with the following parameters : 
* bsselect_search: the characters you are searching for
* search_input_id: the id of the select input 
* search_input_name: the name of the select input

Your controller action must return a template containing the input you want to replace. If your input is a part of a form collection, you 'll have to set the id manually to the returned input using the search_input_id POST.
