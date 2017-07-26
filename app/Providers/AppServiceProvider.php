<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        Blade::directive('haspermission', function ($expression) {
            return "<?php if (auth()->check() && in_array(strtolower({$expression}), getCurrentPermission(auth()->user())['permissions'])): ?>";
        });

        Blade::directive('endhaspermission', function () {
            return '<?php endif; ?>';
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
