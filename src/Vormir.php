<?php

namespace Hadefication\Vormir;

use Spatie\Ssr\Renderer;
use Spatie\Ssr\Engines\Node;

class Vormir
{
    /**
     * Environment variables container
     *
     * @var array
     */
    protected $env = [];

    /**
     * Payload container
     *
     * @var array|object
     */
    protected $payload;
    
    /**
     * Renderer container
     *
     * @var Renderer
     */
    protected $renderer;

    public function __construct() {
        $this->renderer = new Renderer(new Node(
            config()->get('vormir.node.bin'),
            config()->get('vormir.node.temp')
        ));
    }

    /**
     * Payload
     *
     * @param array|object $payload
     * @return self
     */
    public function payload($payload): self
    {
        $this->payload = $payload;
        return $this;
    }

    /**
     * Set env
     *
     * @param array $env
     * @return self
     */
    public function env($env = []): self
    {  
        $this->env = $env;
        return $this;
    }

    /**
     * Render script
     *
     * @param string $entry
     * @return string
     */
    public function render($entry)
    {
        return $this->renderer->debug()
                                ->context('payload', $this->payload)
                                ->env(array_merge([
                                    'VUE_ENV' => "server", 
                                    'NODE_ENV' => "production"
                                ], $this->env))
                                ->entry(public_path("js/{$entry}.js"))
                                ->render();
    }
}
