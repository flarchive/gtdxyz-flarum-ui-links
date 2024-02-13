<?php

namespace Gtdxyz\Links\Api\Controller;

use Flarum\Api\Controller\AbstractCreateController;
use Gtdxyz\Links\Api\Serializer\LinkSerializer;
use Gtdxyz\Links\Command\CreateLink;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class CreateLinkController extends AbstractCreateController
{
    /**
     * {@inheritdoc}
     */
    public $serializer = LinkSerializer::class;

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
    protected function data(ServerRequestInterface $request, Document $document)
    {
        return $this->bus->dispatch(
            new CreateLink($request->getAttribute('actor'), Arr::get($request->getParsedBody(), 'data'))
        );
    }
}
