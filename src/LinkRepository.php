<?php

namespace Gtdxyz\Links;

use Flarum\User\User;

class LinkRepository
{
    /**
     * Find a link by ID.
     *
     * @param int  $id
     * @param User $actor
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     *
     * @return Link
     */
    public function findOrFail($id, User $actor = null)
    {
        return Link::where('id', $id)->firstOrFail();
    }

    /**
     * Get all links.
     */
    public function all()
    {
        return Link::query()->get();
    }
}
