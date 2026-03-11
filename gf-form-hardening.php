<?php
/*---------------------------------
	GF HARDENING
------------------------------------*/
function harden_gravity_forms_validation( $result, $value, $form, $field ) {

    // If already invalid, don't override
    if ( ! $result['is_valid'] ) {
        return $result;
    }

    // -------------------------
    // EMAIL DOMAIN VALIDATION
    // -------------------------
    if ( $field->type === 'email' && ! empty( $value ) ) {

        $blocked_domains = array(
            'example.com',
            'test.com',
            'testing.com',
            'mailinator.com',
            'tempmail.com',
        );

        $domain = strtolower( substr( strrchr( $value, '@' ), 1 ) );

        if ( in_array( $domain, $blocked_domains, true ) ) {
            $result['is_valid'] = false;
            $result['message'] = 'Please enter a valid email address.';
            return $result;
        }
    }

    // -------------------------
    // DATE RANGE VALIDATION
    // -------------------------
    if ( $field->type === 'date' && ! empty( $value ) ) {

        $timestamp = strtotime( $value );

        if ( $timestamp ) {
            $year = (int) date( 'Y', $timestamp );

            if ( $year < 1980 ) {
                $result['is_valid'] = false;
                $result['message'] = 'Please enter a valid date.';
                return $result;
            }
        }
    }

    // -------------------------
    // BLOCK BOT "TEST" VALUES
    // -------------------------
    if ( in_array( $field->type, array( 'text', 'textarea' ), true ) && ! empty( $value ) ) {

        $blocked_values = array(
            'test',
            'testing',
            'asdf',
            '123',
            'n/a',
            'na',
        );

        if ( in_array( strtolower( trim( $value ) ), $blocked_values, true ) ) {
            $result['is_valid'] = false;
            $result['message'] = 'Please enter a valid response.';
            return $result;
        }
    }

    return $result;
}
add_filter( 'gform_field_validation', 'harden_gravity_forms_validation', 10, 4 );
?>
