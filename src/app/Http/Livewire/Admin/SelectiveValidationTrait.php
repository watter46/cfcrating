<?php declare(strict_types=1);

namespace App\Http\Livewire\Admin;

/**
 * array $originalとarray $changedPropertiesをuse先で定義する
 */
trait SelectiveValidationTrait
{
    public function updatedSelectiveValidationTrait(string $property)
    {
        if (!in_array($property, $this->changedProperties)) {
            $this->changedProperties[] = $property;
        }
    }

    public function validateOnlyChanged()
    {
        $rulesForChangedProperties = array_intersect_key($this->rules(), array_flip($this->changedProperties));

        if (!$rulesForChangedProperties) {
            return;
        }

        $validated = $this->validate($rulesForChangedProperties);

        return collect($this->original)
            ->only(collect($validated)->keys())
            ->replaceRecursive($validated)
            ->mapWithKeys(function ($value, $key) {
                if ($key !== 'is_winner') {
                    return [$key => $value];
                }
                
                return ['is_winner' => match ($value) {
                    'true' => true,
                    'false' => false,
                    'null' => null
                }];
            })
            ->toArray();
    }
}