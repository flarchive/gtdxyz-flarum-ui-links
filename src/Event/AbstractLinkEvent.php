<?php

namespace Gtdxyz\Links\Event;

use Flarum\User\User;
use Gtdxyz\Links\Link;

abstract class AbstractLinkEvent
{
    /**
     * @var Link
     */
    public $link;

    /**
     * @var User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    /**
     * @param Link  $link
     * @param User  $actor
     * @param array $data
     */
    public function __construct(Link $link, User $actor, array $data)
    {
        $this->link = $link;
        $this->actor = $actor;
        $this->data = $data;
    }
}
