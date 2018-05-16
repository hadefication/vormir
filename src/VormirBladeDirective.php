<?php

namespace Hadefication\Vormir;

class VormirBladeDirective
{
    /**
     * Renderer container
     *
     * @var Ssr
     */
    protected  $ssr;

    /**
     * Constructor
     *
     * @param Ssr $ssr
     */
    public function __construct(Ssr $ssr) {
        $this->ssr = $ssr;
    }

    /**
     * Render blade directive
     *
     * @param string $entry             the js entry path
     * @param array $payload            the payload
     * @param array $env                the extra env vars
     * @return string
     */
    public function render($entry, $payload = [], $env = [])
    {
        return $this->ssr->env($env)->payload($payload)->render($entry);
    }
}