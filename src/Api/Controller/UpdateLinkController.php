<?php

namespace Gtdxyz\Links\Api\Controller;

use Flarum\Api\Controller\AbstractShowController;
use Gtdxyz\Links\Api\Serializer\LinkSerializer;
use Gtdxyz\Links\Command\EditLink;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class UpdateLinkController extends AbstractShowController
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
        $id = Arr::get($request->getQueryParams(), 'id');
        $actor = $request->getAttribute('actor');
        $data = Arr::get($request->getParsedBody(), 'data');

        return $this->bus->dispatch(
            new EditLink($id, $actor, $data)
        );
    }
}
