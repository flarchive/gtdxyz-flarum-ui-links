<?php

namespace Gtdxyz\Links\Command;

use Gtdxyz\Links\Event\Deleted;
use Gtdxyz\Links\Event\Deleting;
use Gtdxyz\Links\LinkRepository;
use Illuminate\Contracts\Events\Dispatcher;

class DeleteLinkHandler
{
    /**
     * @var LinkRepository
     */
    protected $links;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @param LinkRepository $links
     */
    public function __construct(LinkRepository $links, Dispatcher $events)
    {
        $this->links = $links;
        $this->events = $events;
    }

    /**
     * @param DeleteLink $command
     *
     * @throws \Flarum\User\Exception\PermissionDeniedException
     *
     * @return \Gtdxyz\Links\Link
     */
    public function handle(DeleteLink $command)
    {
        $actor = $command->actor;

        $link = $this->links->findOrFail($command->linkId, $actor);

        $actor->assertAdmin();

        $this->events->dispatch(new Deleting($link, $actor, []));

        $link->delete();

        $this->events->dispatch(new Deleted($link, $actor, []));

        return $link;
    }
}
