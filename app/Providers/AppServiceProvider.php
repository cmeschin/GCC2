<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Email array validator
        Validator::extend('email_array', function($attribute, $value, $parameters, $validator) {
            $value = str_replace(' ','',$value);
            $array = explode(';', $value);
            foreach($array as $email) //loop over values
            {
                $email_to_validate['alert_email'][]=$email;
            }
            $rules = array('alert_email.*'=>'email');
            $messages = array(
                    'alert_email.*'=>trans('validation.email_array')
            );
            $validator = Validator::make($email_to_validate,$rules,$messages);
            if ($validator->passes()) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
