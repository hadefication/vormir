<?php

namespace Hadefication\Vormir;

class VormirBladeDirective
{
    /**
     * Renderer container
     *
     * @var Vormir
     */
    protected  $ssr;

    /**
     * Constructor
     *
     * @param Ssr $ssr
     */
    public function __construct(Vormir $ssr) {
        $this->ssr = $ssr;
    }

    /**
     * Render blade directive
     *
     * @param string $entry             the js entry path
     * @param array $payload            the payload
     * @param array $env                the extra env vars
     * @param string $fallback          the fallback string/content
     * @return string
     */
    public function render($entry, $payload = [], $env = [], $fallback = '')
    {
        return $this->ssr->env($env)
                        ->payload($payload)
                        ->fallbackString($fallback)
                        ->render($entry);
    }
}