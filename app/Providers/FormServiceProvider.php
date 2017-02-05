<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //Register custom bootstrap componenets
        Form::component('bsCheckbox', 'components.form.checkbox', ['name', 'label' => null, 'value']);
        Form::component('bsFile', 'components.form.file', ['name', 'label' => null, 'attributes']);
        Form::component('bsNumber', 'components.form.number', ['name', 'label' => null, 'value', 'attributes']);
        Form::component('bsRadio', 'components.form.radio', ['name', 'label' => null, 'value']);
        Form::component('bsSelect', 'components.form.select', ['name', 'label' => null, 'value', 'default' => 0, 'placeholder' => null, 'attributes' => []]);
        Form::component('bsText', 'components.form.text', ['name', 'label' => null, 'value', 'attributes' => []]);
        Form::component('bsTextarea', 'components.form.textarea', ['name', 'label' => null, 'value', 'attributes' => []]);
        Form::component('selectize', 'components.form.selectize', ['name', 'label' => null, 'value', 'default' => 0, 'placeholder' => null, 'attributes' => []]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
