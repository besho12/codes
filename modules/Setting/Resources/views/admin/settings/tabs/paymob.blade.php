<div class="row">
    <div class="col-md-8">
        {{ Form::checkbox('paymob_enabled', trans('setting::attributes.paymob_enabled'), trans('setting::settings.form.enable_paymob'), $errors, $settings) }}
        {{ Form::text('translatable[paymob_label]', trans('setting::attributes.translatable.paymob_label'), $errors, $settings, ['required' => true]) }}
        {{ Form::textarea('translatable[paymob_description]', trans('setting::attributes.translatable.paymob_description'), $errors, $settings, ['rows' => 3, 'required' => true]) }}
        {{ Form::checkbox('paymob_test_mode', trans('setting::attributes.paymob_test_mode'), trans('setting::settings.form.use_sandbox_for_test_payments'), $errors, $settings) }}

        <div class="{{ old('paymob_enabled', array_get($settings, 'paymob_enabled')) ? '' : 'hide' }}" id="paymob-fields">
            {{ Form::text('paymob_callback_url', trans('setting::attributes.paymob_callback_url'), $errors, $settings, ['required' => true]) }}
            {{ Form::text('paymob_api_key', trans('setting::attributes.paymob_api_key'), $errors, $settings, ['required' => true]) }}
            {{ Form::text('paymob_iframe_id', trans('setting::attributes.paymob_iframe_id'), $errors, $settings, ['required' => true]) }}
            {{ Form::text('paymob_integration_id', trans('setting::attributes.paymob_integration_id'), $errors, $settings, ['required' => true]) }}
            {{ Form::text('paymob_hmac', trans('setting::attributes.paymob_hmac'), $errors, $settings, ['required' => true]) }}
        </div>
    </div>
</div>
