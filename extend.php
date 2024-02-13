<?php

use Flarum\Api\Controller\ShowForumController;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Gtdxyz\Links\Api\Controller;
use Gtdxyz\Links\Api\Serializer\LinkSerializer;
use Gtdxyz\Links\LoadForumLinksRelationship;

return [
    new Extend\Locales(__DIR__.'/locale'),

    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/less/admin.less'),

    (new Extend\Routes('api'))
        ->post('/links', 'links.create', Controller\CreateLinkController::class)
        ->post('/links/order', 'links.order', Controller\OrderLinksController::class)
        ->patch('/links/{id}', 'links.update', Controller\UpdateLinkController::class)
        ->delete('/links/{id}', 'links.delete', Controller\DeleteLinkController::class),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->hasMany('links', LinkSerializer::class),

    (new Extend\ApiController(ShowForumController::class))
        ->addInclude(['links', 'links.parent'])
        ->prepareDataForSerialization(LoadForumLinksRelationship::class),

    (new Extend\Settings())
        ->registerLessConfigVar('gtdxyz-ui-links-show-only-icons-on-mobile', 'gtdxyz-ui-links.show_icons_only_on_mobile', function ($value) {
            return $value ? 'true' : 'false';
        }),
];
