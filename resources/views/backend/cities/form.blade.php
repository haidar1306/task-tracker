<div class="row">

    {{-- Country --}}
    <div class="col-md-6 mb-3">

        <label for="country_id" class="form-label">
            Country <span class="text-danger">*</span>
        </label>

        <select
            name="country_id"
            id="country_id"
            class="form-select @error('country_id') is-invalid @enderror"
        >
            <option value="">Select Country</option>

            @foreach($countries as $country)
                <option
                    value="{{ $country->id }}"
                    {{ old('country_id', $city->country_id ?? '') == $country->id ? 'selected' : '' }}
                >
                    {{ $country->name }}
                </option>
            @endforeach
        </select>

        @error('country_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- State --}}
    <div class="col-md-6 mb-3">

        <label for="state_id" class="form-label">
            State <span class="text-danger">*</span>
        </label>

        <select
            name="state_id"
            id="state_id"
            class="form-select @error('state_id') is-invalid @enderror"
        >
            <option value="">Select State</option>

            @if(isset($states) && $states->count())

                @foreach($states as $state)

                    <option
                        value="{{ $state->id }}"
                        {{ old('state_id', $city->state_id ?? '') == $state->id ? 'selected' : '' }}
                    >
                        {{ $state->name }}
                    </option>

                @endforeach

            @endif

        </select>

        @error('state_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>


    {{-- City Name --}}
    <div class="col-md-12 mb-3">

        <label for="name" class="form-label">
            City Name <span class="text-danger">*</span>
        </label>

        <input
            type="text"
            name="name"
            id="name"
            class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $city->name ?? '') }}"
            placeholder="Enter city name.."
        >

        @error('name')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror

    </div>

</div>


<style>
    .form-label {
        display: block;
        margin-bottom: 8px;
        font-size: 16px;
        font-weight: 400;
        color: #68758a;
    }

    .form-control,
    .form-select {
        width: 100%;
        min-height: 46px;
        padding: 10px 14px;
        border: 1px solid #cfd5e2;
        border-radius: 6px;
        background-color: #fff;
        color: #68758a;
        font-size: 16px;
        box-shadow: none;
    }

    .form-select {
        cursor: pointer;
    }

    .form-control::placeholder {
        color: #8b96a8;
        opacity: 1;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: #86a8ff;
        outline: none;
        box-shadow: 0 0 0 0.15rem rgba(13, 110, 253, 0.10);
    }

    .form-control.is-invalid,
    .form-select.is-invalid {
        border-color: #dc3545;
    }

    .invalid-feedback {
        display: block;
        margin-top: 5px;
        font-size: 14px;
    }
</style>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const countrySelect = document.getElementById('country_id');
    const stateSelect = document.getElementById('state_id');

    const statesUrl = "{{ url('admin/hotels/states') }}";


    if (!countrySelect || !stateSelect) {
        return;
    }

    countrySelect.addEventListener('change', function () {

        const countryId = this.value;

        stateSelect.innerHTML =
            '<option value="">Loading states...</option>';

        stateSelect.disabled = true;

        if (!countryId) {

            stateSelect.innerHTML =
                '<option value="">Select State</option>';

            stateSelect.disabled = false;

            return;
        }

        fetch(statesUrl + "/" + countryId)
        
            .then(response => {

                if (!response.ok) {
                    throw new Error('Failed to fetch states.');
                }

                return response.json();
            })
            .then(states => {

                stateSelect.innerHTML =
                    '<option value="">Select State</option>';

                if (states.length === 0) {

                    stateSelect.innerHTML =
                        '<option value="">No states found</option>';

                } else {

                    states.forEach(state => {

                        const option = document.createElement('option');

                        option.value = state.id; 
                        option.textContent = state.name;

                        stateSelect.appendChild(option);

                    });
                }

                stateSelect.disabled = false;

            })
            .catch(error => {

                console.error('State Fetch Error:', error);

                stateSelect.innerHTML =
                    '<option value="">Unable to load states</option>';

                stateSelect.disabled = false;
            });

    });

});
</script>