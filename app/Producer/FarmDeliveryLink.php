<?php

namespace App\Producer;

class FarmDeliveryLink extends \App\BaseModel
{
    public $timestamps = false;

    protected $with = ['nodeRelationship'];

    /**
     * Validation rules.
     *
     * @var array
     */
    protected $validationRules = [
        'node_id' => 'required',
        'producer_id' => 'required',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'node_id',
        'producer_id',
    ];

    /**
     * Define user relationship.
     *
     * @return Relation
     */
    public function nodeRelationship()
    {
        return $this->hasOne('App\Node\Node', 'id', 'node_id');
    }

    /**
     * Get node.
     *
     * @return Node
     */
    public function getNode()
    {
        return $this->nodeRelationship;
    }
}
