<?php

namespace App\Library;

use Illuminate\Http\Request;
use Illuminate\Routing\RouteCollection;
use Illuminate\Routing\UrlGenerator;
use \Illuminate\Contracts\Routing\UrlGenerator as UrlGeneratorContract;

class CustomUrlGenerator extends UrlGenerator implements UrlGeneratorContract {

    /**
     * Constructor.
     *
     * @param RouteCollection $routes
     * @param Request $request
     */
    public function __construct(RouteCollection $routes, Request $request)
    {
        parent::__construct($routes, $request);
    }

    /**
     * Override route method
     *
     * @param string $name
     * @param array $parameters
     * @param boolean $absolute
     * @return void
     */
    public function route($name, $parameters = [], $absolute = true)
    {
        if (!is_null($route = $this->routes->getByName($name))) {
            return $this->toRoute($route, $parameters, $absolute);
        } else {
            $name = \App::getLocale() . '_' . $name;

            if (!is_null($route = $this->routes->getByName($name))) {
                return $this->toRoute($route, $parameters, $absolute);
            }
        }

        throw new \InvalidArgumentException("Route [{$name}] not defined.");
    }
}