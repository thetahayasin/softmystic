<?php

namespace App\Livewire;

use App\Models\Software;
use Livewire\Component;

class SoftwareRating extends Component
{
    public Software $software;
    public bool $rated = false;
    public int $selectedRating = 0;

    public function mount(Software $software)
    {
        $this->software = $software;
        $this->rated = session()->has("rated_software_{$software->id}");
    }

    public function rate($value)
    {
        if ($this->rated) return;

        $value = in_array($value, [2, 4, 6, 8, 10]) ? $value : 2;

        $total = $this->software->total_ratings + 1;
        $newAvg = (($this->software->average_rating * $this->software->total_ratings) + $value) / $total;

        $this->software->update([
            'total_ratings' => $total,
            'average_rating' => $newAvg,
        ]);

        session()->put("rated_software_{$this->software->id}", true);
        $this->rated = true;
        $this->selectedRating = $value;
    }

    public function render()
    {
        return view('livewire.software-rating');
    }
}
