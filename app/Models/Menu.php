<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'parent_id',
        'position',
        'order',
        'status',
    ];

    /**
     * Get the parent Menu.
     */
    public function parent()
    {
        return $this->belongsTo(Menu::class, 'parent_id');
    }

    /**
     * Get the child categories.
     */
    public function children()
    {
        return $this->hasMany(Menu::class, 'parent_id');
    }

    /**
     * Get the Menu name with indentation based on nesting level.
     */
    public function getIndentedNameAttribute(): string
    {
        $depth = 0;
        $parent = $this->parent;

        while ($parent) {
            $depth++;
            $parent = $parent->parent;
        }

        return str_repeat('- ', $depth) . $this->title;
    }

    /**
     * Get the parent Menu name with indentation.
     */
    public function getIndentedParentNameAttribute(): ?string
    {
        return $this->parent ? $this->parent->indented_name : null;
    }
}
