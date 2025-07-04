<div class="space-y-2 text-center md:text-left">
    <!-- Stars -->
    <div class="flex justify-center md:justify-start">
        <div class="rating rating-sm {{ $rated ? 'pointer-events-none' : '' }}" id="rating-stars-{{ $software->id }}">
            @for ($i = 1; $i <= 5; $i++)
                @php
                    $value = $i * 2;
                    $avgStars = round($software->average_rating / 2, 1);
                    $filled = $avgStars >= $i;
                    $isSelected = $selectedRating === $value;
                @endphp

                <input
                    type="radio"
                    name="rating-{{ $software->id }}"
                    value="{{ $value }}"
                    class="mask mask-star-2 star-input transition-all duration-150
                        {{ $filled ? 'bg-yellow-400' : 'bg-gray-300' }}
                        {{ !$rated ? 'hover:bg-yellow-300 cursor-pointer' : '' }}"
                    wire:click="{{ !$rated ? 'rate('.$value.')' : '' }}"
                    {{ $rated ? 'disabled' : '' }}
                    title="{{ $value/2 }} points"
                    {{ $isSelected ? 'checked' : '' }}
                    data-index="{{ $i }}"
                />
            @endfor
        </div>
    </div>

    <!-- Text Info -->
    <div class="text-sm text-gray-600 flex flex-col items-center md:flex-row md:items-center md:gap-2 md:justify-start">
        <div>
            <strong>{{ number_format($software->average_rating / 2, 1) }}</strong> / 5 from
            <strong>{{ $software->total_ratings }}</strong> votes
        </div>

        @if ($rated)
<span class="text-green-600 inline-flex items-center gap-1 leading-none">
  <span class="text-lg">•</span>
  <svg width="18" height="18" viewBox="0 0 24 24" fill="none"
       xmlns="http://www.w3.org/2000/svg">
    <path d="M20.25 6L9 17.25L3.75 12"
          stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round"/>
  </svg>
</span>
        @endif
    </div>
</div>

@if (!$rated)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const container = document.getElementById('rating-stars-{{ $software->id }}');
            const stars = container.querySelectorAll('.star-input');

            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', () => {
                    for (let i = 0; i <= index; i++) {
                        stars[i].classList.remove('bg-gray-300');
                        stars[i].classList.add('bg-yellow-300');
                    }
                    for (let i = index + 1; i < stars.length; i++) {
                        stars[i].classList.remove('bg-yellow-300', 'bg-yellow-400');
                        stars[i].classList.add('bg-gray-300');
                    }
                });

                container.addEventListener('mouseleave', () => {
                    stars.forEach((s) => {
                        s.classList.remove('bg-yellow-300', 'bg-yellow-400', 'bg-gray-300');
                        const ratingValue = parseInt(s.value);
                        const avg = {{ round($software->average_rating) }};
                        if (ratingValue <= avg) {
                            s.classList.add('bg-yellow-400');
                        } else {
                            s.classList.add('bg-gray-300');
                        }
                    });
                });
            });
        });
    </script>
@endif
