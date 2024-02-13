<?php

namespace Gtdxyz\Links\Command;

use Gtdxyz\Links\Event\Saving;
use Gtdxyz\Links\LinkRepository;
use Gtdxyz\Links\LinkValidator;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;

class EditLinkHandler
{
    /**
     * @var LinkRepository
     */
    protected $links;

    /**
     * @var LinkValidator
     */
    protected $validator;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @param LinkRepository $links
     * @param LinkValidator  $validator
     */
    public function __construct(LinkRepository $links, LinkValidator $validator, Dispatcher $events)
    {
        $this->links = $links;
        $this->validator = $validator;
        $this->events = $events;
    }

    /**
     * @param EditLink $command
     *
     * @throws \Flarum\User\Exception\PermissionDeniedException
     *
     * @return \Gtdxyz\Links\Link
     */
    public function handle(EditLink $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $link = $this->links->findOrFail($command->linkId, $actor);

        $actor->assertAdmin();

        $attributes = Arr::get($data, 'attributes', []);

        if (isset($attributes['title'])) {
            $link->title = $attributes['title'];
        }

        if (isset($attributes['icon'])) {
            $link->icon = $attributes['icon'];
        }

        if (isset($attributes['url'])) {
            $link->url = $attributes['url'];
        }

        if (isset($attributes['isInternal'])) {
            $link->is_internal = $attributes['isInternal'];
        }

        if (isset($attributes['isNewtab'])) {
            $link->is_newtab = $attributes['isNewtab'];
        }

        if (isset($attributes['useRelMe'])) {
            $link->use_relme = $attributes['useRelMe'];
        }

        if (isset($attributes['visibility'])) {
            $link->visibility = $attributes['visibility'];
        }

        $this->events->dispatch(new Saving($link, $actor, $data));

        $this->validator->assertValid($link->getDirty());

        $link->save();

        return $link;
    }
}
