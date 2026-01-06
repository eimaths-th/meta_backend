<script>
    $(document).ready(function() {
        const $form = $('#infinite');
        const fieldConfig = window.fieldConfig || {};
        const fieldSettings = $.extend(true, {}, window.initialFieldSettings || {});
        const $toggleAllEnabled = $('#toggle-all-enabled');
        const $toggleAllRequired = $('#toggle-all-required');

        function containerFor($el) {
            const $focus = $el.closest('.form-focus');
            if ($focus.length) return $focus;
            const $group = $el.closest('.form-group');
            return $group.length ? $group : $el.parent();
        }

        function ensureFieldSetting(fieldKey) {
            if (!fieldSettings[fieldKey]) {
                const defaults = fieldConfig[fieldKey] || {};
                fieldSettings[fieldKey] = {
                    enabled: defaults.default_enabled !== undefined ? !!defaults.default_enabled : true,
                    required: defaults.default_required !== undefined ? !!defaults.default_required : false,
                };
            } else {
                const state = fieldSettings[fieldKey];
                state.enabled = state.enabled === true || state.enabled === '1' || state.enabled === 1;
                state.required = state.required === true || state.required === '1' || state.required === 1;
            }

            if (!fieldSettings[fieldKey].enabled) {
                fieldSettings[fieldKey].required = false;
            }

            return fieldSettings[fieldKey];
        }

        function findFieldWrapper($el) {
            if (!$el || !$el.length) return $();

            // First check if element itself or parent has data-field-input
            const $dataWrapper = $el.closest('[data-field-input]');
            if ($dataWrapper.length) {
                return $dataWrapper.first();
            }

            // Look for .form-group first (most specific)
            const $group = $el.closest('.form-group');
            if ($group.length) {
                const $groupParent = $group.parent();
                // Check if parent is a column, return that column
                if ($groupParent.length && $groupParent.attr('class') && $groupParent.attr('class').match(
                        /col-/)) {
                    return $groupParent;
                }
                return $group.first();
            }

            // Then look for column classes (from smallest to largest to get closest match)
            const columnSelectors = [
                '.col-xl-1', '.col-lg-1', '.col-md-1', '.col-sm-1', '.col-1',
                '.col-xl-2', '.col-lg-2', '.col-md-2', '.col-sm-2', '.col-2',
                '.col-xl-3', '.col-lg-3', '.col-md-3', '.col-sm-3', '.col-3',
                '.col-xl-4', '.col-lg-4', '.col-md-4', '.col-sm-4', '.col-4',
                '.col-xl-5', '.col-lg-5', '.col-md-5', '.col-sm-5', '.col-5',
                '.col-xl-6', '.col-lg-6', '.col-md-6', '.col-sm-6', '.col-6',
                '.col-xl-7', '.col-lg-7', '.col-md-7', '.col-sm-7', '.col-7',
                '.col-xl-8', '.col-lg-8', '.col-md-8', '.col-sm-8', '.col-8',
                '.col-xl-9', '.col-lg-9', '.col-md-9', '.col-sm-9', '.col-9',
                '.col-xl-10', '.col-lg-10', '.col-md-10', '.col-sm-10', '.col-10',
                '.col-xl-11', '.col-lg-11', '.col-md-11', '.col-sm-11', '.col-11',
                '.col-xl-12', '.col-lg-12', '.col-md-12', '.col-sm-12', '.col-12',
            ];

            for (const selector of columnSelectors) {
                const $wrapper = $el.closest(selector);
                if ($wrapper.length) {
                    return $wrapper.first();
                }
            }

            return $el.parent();
        }

        function storeOriginalRequired($inputs) {
            $inputs.each(function() {
                const $input = $(this);
                if ($input.data('original-required') === undefined) {
                    $input.data('original-required', $input.prop('required'));
                }
            });
        }

        function setRequiredState($inputs, shouldRequire) {
            $inputs.each(function() {
                const $input = $(this);
                const inputName = $input.attr('name');

                if (shouldRequire) {
                    $input.prop('required', true).attr('required', 'required');
                    console.log('Set required=true for:', inputName);
                } else {
                    $input.prop('required', false).removeAttr('required');
                    console.log('Removed required for:', inputName);
                }
            });
        }

        function clearValidationState($inputs) {
            $inputs.each(function() {
                const $input = $(this);
                $input.data('invalid', false).css('border', '');
                hideError($input);
            });
        }

        function applyFieldState(fieldKey) {
            const config = fieldConfig[fieldKey];
            if (!config || !config.builder_input) {
                $('[data-field-enabled="' + fieldKey + '"]').prop('disabled', true).prop('checked', false);
                $('[data-field-required="' + fieldKey + '"]').prop('disabled', true).prop('checked', false);
                return;
            }

            const $elements = $form.find(config.builder_input);

            // Try to find wrapper with data-field-input attribute first
            let $wrapper = $('[data-field-input="' + config.public_name + '"]');

            if (!$wrapper.length && $elements.length) {
                $wrapper = findFieldWrapper($elements.first());
            }

            if (!$wrapper.length) {
                console.log('Wrapper not found for field:', fieldKey, 'public_name:', config.public_name);
                $('[data-field-enabled="' + fieldKey + '"]').prop('disabled', true).prop('checked', false);
                $('[data-field-required="' + fieldKey + '"]').prop('disabled', true).prop('checked', false);
                return;
            }

            const $inputs = $wrapper.find('input, select, textarea');
            const $related = $('[data-field-related="' + config.public_name + '"]');
            const hasExistingImagePayment = (fieldKey === 'image_payment') && $('#oldImagePayment').length && $('#oldImagePayment').val();
            const settings = ensureFieldSetting(fieldKey);

            console.log('Applying field state:', fieldKey, 'enabled:', settings.enabled, 'required:', settings
                .required, 'inputs:', $inputs.length);

            storeOriginalRequired($inputs);

            if (!settings.enabled) {
                $wrapper.attr('data-field-visible', '0').hide();
                $related.hide();
                setRequiredState($inputs, false);
                clearValidationState($inputs);

                $('[data-field-required="' + fieldKey + '"]').prop('checked', false).prop('disabled', true);
                $('[data-field-enabled="' + fieldKey + '"]').prop('checked', false);
            } else {
                $wrapper.attr('data-field-visible', '1').show();
                $related.show();
                if (hasExistingImagePayment) {
                    setRequiredState($inputs, false);
                    clearValidationState($inputs);
                } else {
                    setRequiredState($inputs, settings.required);
                }
                $('[data-field-enabled="' + fieldKey + '"]').prop('checked', true);
                $('[data-field-required="' + fieldKey + '"]').prop('disabled', false).prop('checked', settings
                    .required);
                if (hasExistingImagePayment) {
                    $wrapper.attr('data-existing-image', '1');
                } else {
                    $wrapper.removeAttr('data-existing-image');
                }
            }
        }

        function applyAllFieldStates() {
            Object.keys(fieldConfig).forEach(function(fieldKey) {
                applyFieldState(fieldKey);
            });
        }

        function syncHeaderCheckbox($headerCheckbox, $targets) {
            if (!$headerCheckbox.length) return;

            const $enabledTargets = $targets.filter(function() {
                return !this.disabled;
            });

            if (!$enabledTargets.length) {
                $headerCheckbox.prop({
                    checked: false,
                    indeterminate: false,
                    disabled: true
                });
                return;
            }

            const total = $enabledTargets.length;
            const checkedCount = $enabledTargets.filter(':checked').length;

            $headerCheckbox.prop('disabled', false);

            if (checkedCount === 0) {
                $headerCheckbox.prop({
                    checked: false,
                    indeterminate: false
                });
            } else if (checkedCount === total) {
                $headerCheckbox.prop({
                    checked: true,
                    indeterminate: false
                });
            } else {
                $headerCheckbox.prop({
                    checked: false,
                    indeterminate: true
                });
            }
        }

        function updateToggleHeaders() {
            syncHeaderCheckbox($toggleAllEnabled, $('.field-toggle-enabled'));
            syncHeaderCheckbox($toggleAllRequired, $('.field-toggle-required'));
        }

        applyAllFieldStates();
        updateToggleHeaders();

        $('.field-toggle-enabled').on('change', function() {
            const fieldKey = $(this).data('field');
            const enabled = $(this).is(':checked');
            const settings = ensureFieldSetting(fieldKey);
            settings.enabled = enabled;
            if (!enabled) {
                settings.required = false;
            } else if (settings.required === undefined) {
                const defaults = fieldConfig[fieldKey] || {};
                settings.required = defaults.default_required !== undefined ? !!defaults
                    .default_required : false;
            }

            applyFieldState(fieldKey);
            updateToggleHeaders();
        });

        $('.field-toggle-required').on('change', function() {
            const fieldKey = $(this).data('field');
            const settings = ensureFieldSetting(fieldKey);
            settings.required = $(this).is(':checked');
            applyFieldState(fieldKey);
            updateToggleHeaders();
        });

        $toggleAllEnabled.on('change', function() {
            if (!$toggleAllEnabled.length) return;
            const shouldCheck = $(this).is(':checked');
            $(this).prop('indeterminate', false);
            $('.field-toggle-enabled').not(':disabled').prop('checked', shouldCheck).trigger('change');
        });

        $toggleAllRequired.on('change', function() {
            if (!$toggleAllRequired.length) return;
            const shouldCheck = $(this).is(':checked');
            $(this).prop('indeterminate', false);
            $('.field-toggle-required').not(':disabled').prop('checked', shouldCheck).trigger('change');
        });

        function showError($el) {
            const $c = containerFor($el);
            $c.addClass('form-focus-error');
            $c.find('.form-error-message').css('display', 'block');
            $el.css('border', '1px solid red');
        }

        function hideError($el) {
            const $c = containerFor($el);
            $el.css('border', '');
            // If no other invalids inside, hide the message
            const hasOtherInvalid = $c.find('input, textarea, select').filter(function() {
                return $(this).data('invalid') === true;
            }).not($el).length > 0;
            if (!hasOtherInvalid) {
                $c.removeClass('form-focus-error');
                $c.find('.form-error-message').css('display', 'none');
            }
        }

        function isEmpty($el) {
            const type = ($el.attr('type') || '').toLowerCase();
            const tag = $el.prop('tagName');

            if (type === 'file') return ($el[0].files || []).length === 0;
            if (type === 'checkbox' || type === 'radio') {
                const name = $el.attr('name');
                return $form.find(`input[name="${name}"]:checked`).length === 0;
            }
            if (tag === 'SELECT') return !$el.val();
            return ($.trim($el.val()) === '');
        }

        function validateEmail(val) {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return re.test(String(val).toLowerCase());
        }

        function validateField($el) {

            let invalid = false;
            if ($el.is('[required]')) {
                invalid = isEmpty($el);
            }
            // Specific email check

            if (invalid) {
                $el.data('invalid', true);
                showError($el);
            } else {
                $el.data('invalid', false);
                hideError($el);
            }
            return !invalid;
        }

        // Live handlers
        $form.on('input change', 'input, textarea, select', function() {
            validateField($(this));
        });

        // Submit via AJAX with client-side validation
        $form.on('submit', function(e) {
            e.preventDefault();

            let firstInvalid = null;
            // Validate all required fields
            $form.find('input, textarea, select').each(function() {
                const $field = $(this);
                if (!$field.is(':visible') || $field.is(':disabled')) {
                    return;
                }

                // Skip fields with data-no-validation attribute
                if ($field.data('no-validation') === true || $field.attr('data-no-validation') === 'true') {
                    return;
                }

                // Skip fields inside form builder sections (these are for preview/template, not actual form data)
                if ($field.closest('.form-html').length || $field.closest('#options_package').length) {
                    return;
                }

                const ok = validateField($field);
                if (!ok && !firstInvalid) firstInvalid = this;
            });

            if (firstInvalid) {
                $('#error_div').show();
                $('html, body').animate({
                    scrollTop: $(firstInvalid).offset().top - 120
                }, 300);
                return;
            }

            $('#error_div').hide();

            // Prepare FormData (preserves files and all values)
            const formEl = $form.get(0);
            const formData = new FormData(formEl);

            // Show loader and disable submit
            $('#loader-container').show();
            const $submitBtn = $('#send_data').prop('disabled', true);

            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('input[name="_token"]').val(),
                    'Accept': 'application/json'
                },
                success: function(resp, status, xhr) {
                    // If backend returns JSON with redirect/url, follow it; otherwise reload
                    if (resp && (resp.status === 'success')) {
                        //redirect to form-manage
                        toastr.success(resp.message, {
                            timeOut: 3000,
                        });

                        // swal success
                        Swal.fire({
                            icon: 'success',
                            title: 'Success...',
                            text: resp.message,
                            showConfirmButton: false,
                            timer: 3000
                        });

                        setTimeout(function() {
                            window.location.href =
                                '{{ route('form-manage.index') }}';
                        }, 3000);

                        //3 seconds delay

                    } else {
                        $('#loader-container').hide();
                        const $submitBtn = $('#send_data').prop('disabled', false);
                        console.log(resp);
                        // If it redirected server-side, we may get HTML; replace document
                        //each error message show with toastr
                        $.each(resp.errors, function(key, value) {
                            toastr.error(value[0], {
                                timeOut: 5000
                            });
                        });

                        //show each alert class danger

                        $('.alert-danger').show();
                        $.each(resp.errors, function(key, value) {
                            $('.alert-danger').append('<strong><li>' + value +
                                '</li></strong>');
                        });

                        $.each(resp.errors, function(key, value) {
                            const $field = $form.find('[name="' + key + '"]');
                            if ($field.length) {
                                $field.each(function() {
                                    $(this).data('invalid', true);
                                    showError($(this));
                                    if (!firstErrEl) firstErrEl = this;
                                });
                            }
                        });
                    }
                },
                error: function(xhr) {
                    console.log(xhr);
                    // Validation errors (Laravel 422)
                    if (xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
                        const errors = xhr.responseJSON.errors;
                        let firstErrEl = null;
                        Object.keys(errors).forEach(function(name) {
                            // Find field by name (support array names)
                            const $field = $form.find('[name="' + name + '"]');
                            if ($field.length) {
                                $field.each(function() {
                                    $(this).data('invalid', true);
                                    showError($(this));
                                    if (!firstErrEl) firstErrEl = this;
                                });
                                //each show error message with toastr
                                toastr.error(errors[name][0], {
                                    timeOut: 5000
                                });
                            }
                        });
                        $('#error_div').show();
                        const target = firstErrEl || firstInvalid;
                        if (target) $('html, body').animate({
                            scrollTop: $(target).offset().top - 120
                        }, 300);
                    } else {
                        alert('Submission failed. Please try again later.');
                    }
                },
                complete: function() {
                    $('#loader-container').hide();
                    $submitBtn.prop('disabled', false);
                }
            });
        });


        (function() {
            const formSelector = '#select-route-form';
            const $formName = $('#form_name');
            const $slugInput = $('#slug');
            const $slugPreview = $('#slug-preview');
            const previewPlaceholder = 'กรอกชื่อฟอร์มเพื่อสร้าง slug อัตโนมัติ';

            const generateSlug = (value) => {
                if (!value) {
                    return '';
                }

                let slug = value.toString().trim().toLowerCase();

                if (typeof slug.normalize === 'function') {
                    slug = slug.normalize('NFD').replace(/[\u0300-\u036f]/g, '');
                }

                slug = slug
                    .replace(/[^a-z0-9\s-]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');

                return slug;
            };

            const updateSlugPreview = () => {
                const nameValue = $formName.val().trim();
                const slug = generateSlug(nameValue);
                $slugInput.val(slug);

                if (slug) {
                    $slugPreview.text(slug).removeClass('text-muted');
                } else {
                    $slugPreview.text(previewPlaceholder).addClass('text-muted');
                }
            };

            $formName.on('input blur', updateSlugPreview);

            $(document).off('submit', formSelector).on('submit', formSelector, function(e) {
                e.preventDefault();

                const $form = $(this);
                const $submit = $('#select-route-submit');

                updateSlugPreview();
                const slugValue = $slugInput.val();
                if (!slugValue) {
                    toastr.error('กรุณากรอกชื่อฟอร์มเพื่อสร้าง slug');
                    return;
                }

                $submit.prop('disabled', true);

                $.ajax({
                        url: $form.attr('action'),
                        type: 'POST',
                        data: $form.serialize(),
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .done(function(resp) {
                        if (resp?.status === 'success') {
                            toastr.success(resp.message || 'สร้างฟอร์มสำเร็จ');
                            setTimeout(function() {
                                window.location.href = resp.redirect ||
                                    '{{ route('form-manage.index') }}';
                            }, 1200);
                            return;
                        }

                        toastr.error('ไม่สามารถสร้างฟอร์มได้ กรุณาลองใหม่อีกครั้ง');
                    })
                    .fail(function(xhr) {
                        if (xhr.status === 422 && xhr.responseJSON?.errors) {
                            $.each(xhr.responseJSON.errors, function(field, messages) {
                                if (messages?.length) {
                                    toastr.error(messages[0]);
                                }
                            });
                            return;
                        }

                        toastr.error('เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง');
                    })
                    .always(function() {
                        $submit.prop('disabled', false);
                    });
            });
        })();


    });
</script>
{{--  --}}
