<?php
/**
 * Created by PhpStorm.
 * User: imokhles
 * Date: 15/11/2018
 * Time: 02:16
 */

namespace App\Traits;

use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use App\Models\LinkedSocial;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use App\Events\LinkedSocialUpdated;

trait HasLinkedSocial {

    public function linkedSocials(): MorphMany
    {
        return $this->morphMany($this->getLinkedSocialModelClassName(), 'model', 'model_type', $this->getModelKeyColumnName())
            ->latest('id');
    }

    public function linkedSocial(): ?LinkedSocial
    {
        return $this->latestLinkedSocial();
    }

    /**
     * @param mixed ...$identifiers
     * @return LinkedSocial|null
     */
    public function latestLinkedSocial(...$identifiers): ?LinkedSocial
    {
        $identifiers = is_array($identifiers) ? array_flatten($identifiers) : func_get_args();
        $linkedSocials = $this->relationLoaded('linked_socials') ? $this->linkedSocials : $this->linkedSocials();
        if (count($identifiers) < 1) {
            return $linkedSocials->first();
        }
        return $linkedSocials->whereIn('provider_id', $identifiers)->first();
    }

    public function setLinkedSocial(array $accountInfo): self
    {

        if (! $this->isValidLinkedSocial($accountInfo)) {
            // Todo: throw error if invalid info
//            throw InvalidLinkedSocial::create($accountInfo);
        }
        return $this->forceSetLinkedSocial($accountInfo);
    }

    public function isValidLinkedSocial(array $accountInfo): bool
    {
        return true;
    }

    public function forceSetLinkedSocial(array $accountInfo): self
    {
        $oldLinkedSocial = $this->latestLinkedSocial();
        $newLinkedSocial = $this->linkedSocials()->create($accountInfo);

        // TODO: check if it works fine :)
        event(new LinkedSocialUpdated($oldLinkedSocial, $newLinkedSocial, $this));
        return $this;
    }

    public function scopeCurrentLinkedSocial(Builder $builder, ...$identifiers)
    {
        $identifiers = is_array($identifiers) ? array_flatten($identifiers) : func_get_args();
        $builder
            ->whereHas(
                'linked_socials',
                function (Builder $query) use ($identifiers) {
                    $query
                        ->whereIn('provider_id', $identifiers)
                        ->whereIn(
                            'id',
                            function (QueryBuilder $query) {
                                $query
                                    ->select(DB::raw('max(id)'))
                                    ->from($this->getLinkedSocialTableName())
                                    ->where('model_type', $this->getLinkedSocialModelType())
                                    ->groupBy($this->getModelKeyColumnName());
                            }
                        );
                }
            );
    }

    public function scopeOtherCurrentStatus(Builder $builder, ...$identifiers)
    {
        $identifiers = is_array($identifiers) ? array_flatten($identifiers) : func_get_args();
        $builder
            ->whereHas(
                'linked_socials',
                function (Builder $query) use ($identifiers) {
                    $query
                        ->whereNotIn('provider_id', $identifiers)
                        ->whereIn(
                            'id',
                            function (QueryBuilder $query) use ($identifiers) {
                                $query
                                    ->select(DB::raw('max(id)'))
                                    ->from($this->getLinkedSocialTableName())
                                    ->where('model_type', $this->getLinkedSocialModelType())
                                    ->groupBy($this->getModelKeyColumnName());
                            }
                        );
                }
            )
            ->orWhereDoesntHave('linked_socials');
    }

    public function getLinkedSocialAttribute(): string
    {
        return (string) $this->latestLinkedSocial();
    }

    protected function getLinkedSocialTableName(): string
    {
        $modelClass = $this->getLinkedSocialModelClassName();
        return (new $modelClass)->getTable();
    }
    protected function getModelKeyColumnName(): string
    {
        return 'model_id';
    }
    protected function getLinkedSocialModelClassName(): string
    {
        return LinkedSocial::class;
    }
    protected function getLinkedSocialModelType(): string
    {
        return array_search(static::class, Relation::morphMap()) ?: static::class;
    }

}