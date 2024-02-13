<?php

namespace Gtdxyz\Links\Api\Serializer;

use Flarum\Api\Serializer\AbstractSerializer;

class LinkSerializer extends AbstractSerializer
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'links';

    /**
     * @param \Gtdxyz\Links\Link $link
     */
    protected function getDefaultAttributes($link)
    {
        return [
            'id'                  => $link->id,
            'title'               => $link->title,
            'icon'                => $link->icon,
            'url'                 => $link->url,
            'position'            => $link->position,
            'isInternal'          => $link->is_internal,
            'isNewtab'            => $link->is_newtab,
            'useRelMe'            => $link->use_relme,
            'isChild'             => (bool) $link->parent_id,
            'visibility'          => $link->visibility,
        ];
    }

    /**
     * @param \Gtdxyz\Links\Link $link
     *
     * @return \Tobscure\JsonApi\Relationship
     */
    protected function parent($link)
    {
        return $this->hasOne($link, self::class);
    }
}
