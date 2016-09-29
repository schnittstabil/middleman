<?php

namespace mindplay\middleman;

use Interop\Http\Middleware\DelegateInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * PSR-15 delegate wrapper for internal callbacks generated by {@see Dispatcher} during dispatch.
 *
 * @internal
 */
class Delegate implements DelegateInterface
{
    /**
     * @var callable
     */
    private $callback;

    /**
     * @param callable $callback function (RequestInterface $request) : ResponseInterface
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function process(RequestInterface $request)
    {
        return call_user_func($this->callback, $request);
    }

    /**
     * Dispatch the next available middleware and return the response.
     *
     * This method duplicates `next()` to provide backwards compatibility with non-PSR 15 middleware.
     *
     * @param RequestInterface $request
     *
     * @return ResponseInterface
     */
    public function __invoke(RequestInterface $request)
    {
        return call_user_func($this->callback, $request);
    }
}
