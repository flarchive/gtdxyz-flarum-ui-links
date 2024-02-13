<?php

namespace Gtdxyz\Links\Api\Controller;

use Flarum\Api\Controller\AbstractDeleteController;
use Gtdxyz\Links\Command\DeleteLink;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;

class DeleteLinkController extends AbstractDeleteController
{
    /**
     * @var Dispatcher
     */
    protected $bus;

    /**
     * @param Dispatcher $bus
     */
    public function __construct(Dispatcher $bus)
    {
        $this->bus = $bus;
    }

    /**
     * {@inheritdoc}
     */
    protected function delete(ServerRequestInterface $request)
    {
        $this->bus->dispatch(
            new DeleteLink(Arr::get($request->getQueryParams(), 'id'), $request->getAttribute('actor'))
        );
    }
}
