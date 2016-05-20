# AXIOLAB BOOTSTRAPSELECTBUNDLE

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
        preferred_language: "en_US" # The language for the translations (cf i18N)
        show_tick: true # Displays a check icon on the selected option(s)
        search_start: 3 # If you use bootstrapselect live_search with ajax, this is the minimum characters to provide before an ajax request is launched
```

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
                'subtext' => 'titi', // Allows you to add subtext to your options
                'keywords' => 'tutu', // Allows you to add keywords to the live_search(ajax or not)
                'multiselect' => [ // Allows you to select many choices
                    'enabled' => false, //Enable/disable the multiselect
                    'max-options' => 5, // Set the maximum of selectable options
                    'selected_text_format' => "...",
                ],
                'live_search' => [
                    'enabled' => true, //Enable/disable the live_search
                    'ajax' => false, //Enable/disable ajax for the live_search
                ],
            ],
```
