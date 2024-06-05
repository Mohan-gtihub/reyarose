@extends('master.front')

@section('title')
    {{ __('Billing') }}
@endsection

@section('content')
    <!-- Page Title-->
    <div class="container pt-8 pt-lg-12 pt-xxl-60 pb-60 pb-lg-80 pb-xxl-100">
        <h2 class="mb-0 text-center fw-bold text-dark heading-h2">
            {{ __('Billing address') }}
        </h2>
        <div class="d-flex align-items-center justify-content-center mt-4">
            <div>
                <a href="{{ route('front.index') }}" class="fs-16 fw text-dark"> Home </a>
            </div>
            <div class="text-gray-700 ms-2">-</div>
            <p class="text-gray-700 ms-2 mb-0">{{ __('Billing address') }}</p>
        </div>
    </div>

    <!-- Page Content-->
    <div class="container padding-bottom-3x mb-1 checkut-page">
        <div class="row">
            <!-- Billing Adress-->
            <div class="col-xl-9 col-lg-8">
                <div class="steps flex-sm-nowrap mb-5"><a class="step active" href="{{ route('front.checkout.billing') }}">
                        <h4 class="step-title">1. {{ __('Billing Address') }}:</h4>
                    </a><a class="step" href="javascript:;">
                        <h4 class="step-title">2. {{ __('Shipping Address') }}:</h4>
                    </a><a class="step" href="{{ route('front.checkout.payment') }}">
                        <h4 class="step-title">3. {{ __('Review and pay') }}</h4>
                    </a>
                </div>
                <div class="card">
                    <div class="card-body">
                        <h6>{{ __('Billing Address') }}</h6>

                        <form id="checkoutBilling" action="{{ route('front.checkout.store') }}" method="POST">
                          @csrf
                          <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label for="checkout-fn">{{ __('First Name') }}</label>
                                      <input class="form-control" name="bill_first_name" type="text" id="checkout-fn" placeholder="E.g., Rohan" value="{{ old('bill_first_name', isset($user) ? $user->first_name : '') }}">
                                      @if ($errors->has('bill_first_name'))
                                          <span class="text-danger">{{ $errors->first('bill_first_name') }}</span>
                                      @endif
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label for="checkout-ln">{{ __('Last Name') }}</label>
                                      <input class="form-control" name="bill_last_name" type="text" id="checkout-ln" placeholder="E.g., Sharma" value="{{ old('bill_last_name', isset($user) ? $user->last_name : '') }}">
                                      @if ($errors->has('bill_last_name'))
                                          <span class="text-danger">{{ $errors->first('bill_last_name') }}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-sm-6">
                                  <div class="form-group">
                                      <label for="checkout_email_billing">{{ __('E-mail Address') }}</label>
                                      <input class="form-control" name="bill_email" type="email" id="checkout_email_billing" placeholder="E.g., example@example.com" value="{{ old('bill_email', isset($user) ? $user->email : '') }}">
                                      @if ($errors->has('bill_email'))
                                          <span class="text-danger">{{ $errors->first('bill_email') }}</span>
                                      @endif
                                  </div>
                              </div>
                              <div class="col-sm-6">
                                  
                                  <div class="form-group">
                                      <label for="checkout-phone">{{ __('Phone Number') }}</label>
                                      <input class="form-control" name="bill_phone" type="text" id="checkout-phone" onchange="validatePhoneNumber(this)" placeholder="E.g., 9876543210"
                                          value="{{ old('bill_phone', isset($user) ? $user->phone : '') }}">
                                      @if ($errors->has('bill_phone'))
                                          <span class="text-danger">{{ $errors->first('bill_phone') }}</span>
                                      @endif
                                  </div>
                              </div>
                          </div>
                          @if (PriceHelper::CheckDigital())
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="checkout-company">{{ __('Company') }}</label>
                                          <input class="form-control" name="bill_company" type="text" id="checkout-company" placeholder="E.g., ABC Pvt. Ltd." value="{{ old('bill_company', isset($user) ? $user->bill_company : '') }}">
                                          @if ($errors->has('bill_company'))
                                              <span class="text-danger">{{ $errors->first('bill_company') }}</span>
                                          @endif
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="checkout-gst">{{ __('GST') }}</label>
                                          <input class="form-control" name="gst" type="text" id="checkout-gst" placeholder="E.g., AB12CDE34FG567H" value="{{ old('gst', isset($user) ? $user->gst : '') }}">
                                          @if ($errors->has('gst'))
                                              <span class="text-danger">{{ $errors->first('gst') }}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="checkout-address1">{{ __('Address') }} 1</label>
                                          <input class="form-control" name="bill_address1" type="text" id="checkout-address1" placeholder="E.g., 123, Main Street" value="{{ old('bill_address1', isset($user) ? $user->bill_address1 : '') }}">
                                          @if ($errors->has('bill_address1'))
                                              <span class="text-danger">{{ $errors->first('bill_address1') }}</span>
                                          @endif
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="checkout-address2">{{ __('Address') }} 2</label>
                                          <input class="form-control" name="bill_address2" type="text" id="checkout-address2" placeholder="E.g., Near Park Avenue (optional)" value="{{ old('bill_address2', isset($user) ? $user->bill_address2 : '') }}">
                                          @if ($errors->has('bill_address2'))
                                              <span class="text-danger">{{ $errors->first('bill_address2') }}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="checkout-zip">{{ __('Zip Code') }}</label>
                                          <input class="form-control" name="bill_zip" type="text" id="checkout-zip" placeholder="E.g., 110001" value="{{ old('bill_zip', isset($user) ? $user->bill_zip : '') }}">
                                          @if ($errors->has('bill_zip'))
                                              <span class="text-danger">{{ $errors->first('bill_zip') }}</span>
                                          @endif
                                      </div>
                                  </div>
                                  <div class="col-sm-6">
                                      <div class="form-group">
                                          <label for="checkout-city">{{ __('City') }}</label>
                                          <input class="form-control" name="bill_city" type="text" id="checkout-city" placeholder="E.g., New Delhi" value="{{ old('bill_city', isset($user) ? $user->bill_city : '') }}">
                                          @if ($errors->has('bill_city'))
                                              <span class="text-danger">{{ $errors->first('bill_city') }}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                              <div class="row">
                                  <div class="col-sm-12">
                                      <div class="form-group">
                                          <label for="billing-country">{{ __('Country') }}</label>
                                          <select class="form-control" name="bill_country" id="billing-country">
                                              <option selected disabled>{{ __('Choose Country') }}</option>
                                              @foreach (DB::table('countries')->get() as $country)
                                                  <option value="{{ $country->name }}" {{ old('bill_country', isset($user) ? $user->bill_country : '') == $country->name ? 'selected' : '' }}>{{ $country->name }}</option>
                                              @endforeach
                                          </select>
                                          @if ($errors->has('bill_country'))
                                              <span class="text-danger">{{ $errors->first('bill_country') }}</span>
                                          @endif
                                      </div>
                                  </div>
                              </div>
                          @endif
                      
                          <div class="form-group">
                              <div class="custom-control custom-checkbox d-flex">
                                  <input class="form-check-input px-2" type="checkbox" id="same_address" name="same_ship_address" {{ old('same_ship_address') ? 'checked' : '' }}>
                                  <label class="custom-control-label ms-2 " for="same_address">{{ __('Same as billing address') }}</label>
                              </div>
                          </div>
                      
                          @if ($setting->is_privacy_trams == 1)
                              <div class="form-group">
                                  <div class="custom-control custom-checkbox d-flex">
                                      <input class="form-check-input px-2" type="checkbox" id="trams__condition">
                                      <label class="custom-control-label ms-2" for="trams__condition">This site is protected by reCAPTCHA and the <a class="text-danger"
                                              href="{{ $setting->policy_link }}" target="_blank">{{ __('Privacy Policy') }}</a> and <a class="text-danger" href="{{ $setting->terms_link }}"
                                              target="_blank">{{ __('Terms of Service') }}</a> apply.</label>
                                  </div>
                              </div>
                          @endif
                      
                          <div class="d-flex justify-content-between paddin-top-1x mt-4">
                              <a class="btn btn-danger text-white btn-sm" href="{{ route('front.cart') }}"><span class="">{{ __('Back To Cart') }}</span></a>
                              @if ($setting->is_privacy_trams == 1)
                                  <button disabled id="continue__button" class="btn btn-danger text-white btn-sm" type="button"><span class="">{{ __('Continue') }}</span></button>
                              @else
                                  <button class="btn btn-danger text-white btn-sm" type="submit"><span class="">{{ __('Continue') }}</span></button>
                              @endif
                          </div>
                      </form>
                      
                      
                      
                    </div>
                </div>
            </div>
            <!-- Sidebar          -->
            @include('includes.checkout_sitebar', $cart)
        </div>
    </div>
@endsection
@section('script')
<script>
    function validatePhoneNumber(input) {
        var phoneNumber = input.value;
        // Validate Indian phone number format
        var regex = /^[6-9]\d{9}$/;
        if (!regex.test(phoneNumber)) {
          DangerNotification("Please enter a valid Indian phone number.");
            input.value = '';
        }
    }
</script>
@endsection