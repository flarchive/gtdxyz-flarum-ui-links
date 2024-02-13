<?php

namespace Gtdxyz\Links;

use Flarum\Api\Controller\ShowForumController;
use Flarum\Foundation\Config;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;

class LoadForumLinksRelationship
{
    /** @var Config */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * @param ShowForumController    $controller
     * @param                        $data
     * @param ServerRequestInterface $request
     */
    public function __invoke(ShowForumController $controller, &$data, ServerRequestInterface $request)
    {
        /** @var \Flarum\User\User */
        $actor = $request->getattribute('actor');
        $adminPath = Arr::get($this->config, 'paths.admin');

        // Admin Panel list all items
        if ($actor->isAdmin() && $request->getServerParams()['REQUEST_URI'] === "/$adminPath") {
            return $data['links'] = Link::all();
        }

        // Admin
        if($actor->isAdmin()){
            return $data['links'] = Link::all();
        }

        // members or guests
        $data['links'] = $actor->isGuest() ?
            Link::where('visibility', 'guests')->orWhere('visibility', 'everyone')->get() :
            Link::where('visibility', 'members')->orWhere('visibility', 'everyone')->get();
    }
}
