<?php
    namespace App;

    class Router {

        private array $routes;

        public function add (
            string $httpMethod = "GET",
            string $route,
            callable|array $handler
        ): self {
            $httpMethod = \strtolower($httpMethod);

            $this->routes[$httpMethod][$route] = $handler;

            return $this;
        }

        public function fallback (
            callable $handler
        ): self {
            $this->routes["/404"] = $handler;

            return $this;
        }

        public function run (string $httpMethod, string $url): void {
            $httpMethod = \strtolower($httpMethod);

            $urlParsed = \parse_url($url);
            $route = $urlParsed["path"];
            $query = $urlParsed["query"] ?? NULL;

            \parse_str( $query, $queryParams );

            if ( !\array_key_exists($httpMethod, $this->routes) ) {
                $this->notFound();
            }

            if (array_key_exists($route, $this->routes[$httpMethod])) {
                $handler = $this->routes[$httpMethod][$route];

                if (\is_array($handler)) {
                    list($controller, $method) = $handler;

                    $controller = new $controller;
                    $controller->$method();

                    return;
                }

                $handler($queryParams);

                return;
            }

            $this->notFound();

        }

        private function notFound (): void {
            if ( array_key_exists("/404", $this->routes) ) {
                $handler = $this->routes["/404"];

                $handler();

                return;
            }

            throw new \Exception("Something went wrong with routing logic");
        }

    }