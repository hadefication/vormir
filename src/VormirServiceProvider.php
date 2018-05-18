<?php
namespace Hadefication\Vormir;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class VormirServiceProvider extends ServiceProvider
{
    /**
     * Boot
     *
     * @return void
     */
    public function boot()
    {
        Blade::directive('ssr', function ($expression) {
            return "<?php echo app('" . VormirBladeDirective::class . "')->render($expression); ?>";
        });

        $this->publishes([
            __DIR__ . '/config.php' => config_path('ssr.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/config.php', 'ssr'
        );
    }
}
