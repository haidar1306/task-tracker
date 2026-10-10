@csrf

<div class="row">

    {{-- Country --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">
            Country <span class="text-danger">*</span>
        </label>

        <select
            name="country_id"
            id="country_id"
            class="form-control @error('country_id') is-invalid @enderror"
        >
            <option value="">Select Country</option>

            @foreach ($countries as $country)
                <option
                    value="{{ $country->id }}"
                    {{ old('country_id', $hotel->country_id ?? '') == $country->id ? 'selected' : '' }}
                >
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        @error('country_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- State --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">
            State <span class="text-danger">*</span>
        </label>

        <select
            name="state_id"
            id="state_id"
            class="form-control @error('state_id') is-invalid @enderror"
        >
            <option value="">Select State</option>

            @if(isset($states))
                @foreach ($states as $state)
                    <option
                        value="{{ $state->id }}"
                        {{ old('state_id', $hotel->state_id ?? '') == $state->id ? 'selected' : '' }}
                    >
                        {{ $state->name }}
                    </option>
                @endforeach
            @endif
        </select>

        @error('state_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- City --}}
    <div class="col-md-4 mb-3">
        <label class="form-label">
            City <span class="text-danger">*</span>
        </label>

        <select
            name="city_id"
            id="city_id"
            class="form-control @error('city_id') is-invalid @enderror"
        >
            <option value="">Select City</option>

            @if(isset($cities))
                @foreach ($cities as $city)
                    <option
                        value="{{ $city->id }}"
                        {{ old('city_id', $hotel->city_id ?? '') == $city->id ? 'selected' : '' }}
                    >
                        {{ $city->name }}
                    </option>
                @endforeach
            @endif
        </select>

        @error('city_id')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>


    {{-- Hotel Name --}}
    <div class="col-md-12 mb-3">
        <label class="form-label">
            Hotel Name <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="name"
            value="{{ old('name', $hotel->name ?? '') }}"
            class="form-control @error('name') is-invalid @enderror"
            placeholder="Enter hotel name.."
        >

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

</div>


<div class="mt-3">
    <button type="submit" class="btn btn-primary">
        {{ isset($hotel) ? 'Update Hotel' : 'Save Hotel' }}
    </button>

    <a href="{{ route('admin.hotels.index') }}" class="btn btn-secondary">
        Cancel
    </a>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const countryDropdown = document.getElementById('country_id');
    const stateDropdown = document.getElementById('state_id');
    const cityDropdown = document.getElementById('city_id');

    const statesUrl = "{{ url('admin/hotels/states') }}";
    const citiesUrl = "{{ url('admin/hotels/cities') }}";


    //fetch state from countries....
    countryDropdown.addEventListener('change', function () {

        const countryId = this.value;

        stateDropdown.innerHTML =
            '<option value="">Select State</option>';

        cityDropdown.innerHTML =
            '<option value="">Select City</option>';

        if (!countryId) {
            return;
        }

        fetch( "{{ url('admin/hotels/states') }}/" + countryId)
            .then(response => response.json())
            .then(states => {

                states.forEach(state => {

                    const option = document.createElement('option');

                    option.value = state.id;
                    option.textContent = state.name;

                    stateDropdown.appendChild(option);
                });

            })
            .catch(error => {
                console.error('Error loading states:', error);
            });
    });


    // fetch cities from states...
    stateDropdown.addEventListener('change', function () {

        const stateId = this.value;

        cityDropdown.innerHTML =
            '<option value="">Select City</option>';

        if (!stateId) {
            return;
        }

        fetch( "{{ url('admin/hotels/cities') }}/" + stateId)
            .then(response => response.json())
            .then(cities => {

                cities.forEach(city => {

                    const option = document.createElement('option');

                    option.value = city.id;
                    option.textContent = city.name;

                    cityDropdown.appendChild(option);
                });

            })
            .catch(error => {
                console.error('Error loading cities:', error);
            });
    });

});
</script>