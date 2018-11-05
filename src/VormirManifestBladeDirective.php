<?php
namespace Hadefication\Vormir;

class VormirManifestBladeDirective {
    /**
     * Manifest file to read
     */
    protected $manifest_files = '';

    protected $assets = [];

    protected $css_regex = '/css/';

    protected $js_regex = '/js/';

    protected $exclude = '/(map|html|service-worker|png|svg|ico)/';

    public function __construct()
    {
        $this->public_path = public_path('asset-manifest.json');
        $this->manifest_file = file_get_contents($this->public_path);
        $this->assets_array = json_decode($this->manifest_file, true);
        $this->assets = collect($this->assets_array)->reject(function ($key, $value) {
            return preg_match($this->exclude, $key);
        });
    }

    public function css($only)
    {
        $css = $this->assets->reject((function($key, $value) {
            return preg_match($this->js_regex, $key);
        }))->map(function ($url) {
            return '<link rel="stylesheet" type="text/css" href="' . $url . '" />';
        })->toArray();
        return implode(' ', $css);
    }
    public function js($only)
    {
        $js = $this->assets->reject((function($key, $value) {
            return preg_match($this->css_regex, $value);
        }))->map(function ($url) {
            return '<script src="' . $url . '"></script>';
        })->reverse()->toArray();
        return implode(' ', $js);
    }
}
