<div class="js-cookie-consent cookie-consent ">
    <div class="container">
        <div class="cookie-container d-flex justify-content-between">
          <span class="cookie-consent__message">
            {{ $setting->cookie_text }}
          </span>
          <button class="btn btn-info js-cookie-consent-agree cookie-consent__agree">
              {{ __('Allow Cookies') }}
          </button>
        </div>
      </div>
</div>