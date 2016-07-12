<?php

namespace App\Providers;

use Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		/*Blade::directive('select', function ($obj) {
			$select = var_export(func_get_args(), true);
			//$select = "<select $attr>";

			foreach($obj as $i => $v){
				$select .= "<option value=\"$v->id\">$v->name</option>";
			}
			$select .= '</select>';
			return $select;
		});*/
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
