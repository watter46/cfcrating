<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;


class MacroCollectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Collection::macro('recursiveCollect', function (): Collection {
            $wrapCollectionRecursive = function ($items) use (&$wrapCollectionRecursive) {
                if (is_array($items)) {
                    return collect($items)
                        ->map(function ($item) use ($wrapCollectionRecursive) {
                            if (is_array($item)) {
                                return $wrapCollectionRecursive($item);
                            }
        
                            return $item;
                        });
                }
                
                return collect($items);
            };
        
            return $wrapCollectionRecursive($this->toArray());
        });
        
        Collection::macro('getDot', function (string $key) {
            $data = $this->toArray();
            
            return collect(data_get($data, $key))->recursiveCollect();
        });

        Collection::macro('getDotRaw', function (string $key) {
            $data = $this->toArray();
            
            return data_get($data, $key);
        });

        Collection::macro('setDot', function (string $key, $value): Collection {
            $data = $this->toArray();
            
            return collect(data_set($data, $key, $value));
        });
    }
}
