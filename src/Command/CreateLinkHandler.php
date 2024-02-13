<?php

namespace Gtdxyz\Links\Command;

use Gtdxyz\Links\Event\Created;
use Gtdxyz\Links\Event\Creating;
use Gtdxyz\Links\Link;
use Gtdxyz\Links\LinkValidator;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;

class CreateLinkHandler
{
    /**
     * @var LinkValidator
     */
    protected $validator;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @param LinkValidator $validator
     */
    public function __construct(LinkValidator $validator, Dispatcher $events)
    {
        $this->validator = $validator;
        $this->events = $events;
    }

    /**
     * @param CreateLink $command
     *
     * @return Link
     */
    public function handle(CreateLink $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $actor->assertAdmin();

        $link = Link::build(
            Arr::get($data, 'attributes.title'),
            Arr::get($data, 'attributes.icon'),
            Arr::get($data, 'attributes.url'),
            Arr::get($data, 'attributes.isInternal'),
            Arr::get($data, 'attributes.isNewtab'),
            Arr::get($data, 'attributes.visibility'),
            Arr::get($data, 'attributes.useRelMe')
        );

        $parentId = Arr::get($data, 'relationships.parent.data.id');

        if ($parentId !== null) {
            $rootLinks = Link::query()->whereNull('parent_id')->whereNotNull('position');

            if ($parentId === 0) {
                $link->position = $rootLinks->max('position') + 1;
            } elseif ($rootLinks->find($parentId)) {
                $position = Link::query()->where('parent_id', $parentId)->max('position');

                $link->parent()->associate($parentId);
                $link->position = $position === null ? 0 : $position + 1;
            }
        }

        $this->events->dispatch(new Creating($link, $actor, $data));

        $this->validator->assertValid($link->getAttributes());

        $link->save();

        $this->events->dispatch(new Created($link, $actor, []));

        return $link;
    }
}
