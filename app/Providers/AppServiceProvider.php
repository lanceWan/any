<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Permission;
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

        // $this->bladeDirective();
        Blade::directive('haspermission', function ($expression) {
            $expression = strtolower(trim($expression, "'"));
            $check = false;
            if (auth()->check()) {
                
                $user = auth()->user();
                $userPermissions =  getCurrentPermission($user);

                $check = in_array($expression, $userPermissions['permissions']);

                if (in_array('admin', $userPermissions['roles']) && !$check) {
                    $permission = Permission::firstOrCreate([
                        'slug' => $expression,
                    ],[
                        'name' => $expression,
                        'description' => $expression,
                    ]);
                    $user->attachPermission($permission);
                    setUserPermissions($user);
                    $check = true;
                }
            }

            return "<?php if ( {$check} ): ?>";
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
    /**
     * 自定义指令
     * @author 晚黎
     * @date   2017-07-27T13:50:21+0800
     * @return [type]                   [description]
     */
    private function bladeDirective()
    {
        Blade::directive('haspermission', function ($expression) {
            // $expression = strtolower(trim($expression, "'"));
            $check = false;
            if (auth()->check()) {
                
                $user = auth()->user();
                $userPermissions =  getCurrentPermission($user);

                $check = in_array($expression, $userPermissions['permissions']);

                if (in_array('admin', $userPermissions['roles']) && !$check) {
                    $permission = Permission::firstOrCreate([
                        'slug' => $expression,
                    ],[
                        'name' => $expression,
                        'description' => $expression,
                    ]);
                    $user->attachPermission($permission);
                    setUserPermissions($user);
                    $check = true;
                }
            }

            return "<?php if ( {$check} ): ?>";
        });

        Blade::directive('endhaspermission', function () {
            return '<?php endif; ?>';
        });
    }
}
