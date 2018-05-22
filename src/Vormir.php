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
     * Fallback content container
     *
     * @var string
     */
    protected $content = '';
    
    /**
     * Renderer container
     *
     * @var Renderer
     */
    protected $renderer;

    /**
     * Constructor
     */
    public function __construct() {
        $this->renderer = new Renderer(new Node(
            config()->get('ssr.node.bin_path'),
            config()->get('ssr.node.temp_path')
        ));
    }

    /**
     * Payload
     *
     * @param array|object $payload             the data payload to include
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
     * @param array $env            the additional environment variables to load to Node.js
     * @return self
     */
    public function env($env = []): self
    {  
        $this->env = $env;
        return $this;
    }

    /**
     * Fallback render if anything goes bad
     *
     * @param string $content
     * @return self
     */
    public function fallbackString($content = ''): self
    {
        $this->content = $content;
        return $this;
    }

    /**
     * Render script
     *
     * @param string $entry             the JavaScript file entry to render
     * @return string
     */
    public function render($entry)
    {
        return $this->renderer->enabled(config()->get('ssr.enabled', true))
                            ->debug(config()->get('ssr.debug', true))
                            ->context('payload', $this->payload)
                            ->env(array_merge(config()->get('ssr.env'), [
                                'NODE_ENV' => "production"
                            ], $this->env))
                            ->entry(config()->get('ssr.js_path') . "/{$entry}")
                            ->fallback($this->content)
                            ->render();
    }
}
