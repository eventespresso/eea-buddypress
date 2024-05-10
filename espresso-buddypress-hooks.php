<?php
/* Start EE BuddyPress */

/* Record the activity of the EE4 component */
function ee_buddypress_record_registration_activity($registration)
{
    // Don't run if Activity Streams are inactive
    if (! bp_is_active('activity')) {
        return;
    }

    if ($registration->attendee() instanceof EE_Attendee) {
        $event_id = $registration->event()->ID();
        $user_id  = bp_loggedin_user_id();
        // $user_link = bp_core_get_userlink( $user_id, $no_anchor = false, $just_link = false );

        if (! empty($user_id)) {
            bp_activity_add(
                [
                    'item_id'   => $registration->event()->ID(),
                    'user_id'   => $user_id,
                    'component' => 'event_registration',
                    'type'      => 'ee_event_registration',
                    'action'    => 'Event Registration',
                    'content'   => 'Registered for <a href="'
                                   . get_permalink($event_id)
                                   . '">'
                                   . $registration->event()
                                                  ->name()
                                   . '</a>',
                ]
            );
        }
    }
}


add_action(
    'AHEE__thank_you_page_registration_details_template__after_registration_table_row',
    'ee_buddypress_record_registration_activity',
    10,
    1
);

/* Adds the "Event Registrations" option to the BuddyPress sitewide Activity directory filter/dropdown */
function ee_buddypress_activity_filter()
{
    ?>
    <option value="ee_event_registration"><?php _e('Event Registrations', 'ee_buddypress'); ?></option>
    <?php
}


// Activity Directory
add_action('bp_activity_filter_options', 'ee_buddypress_activity_filter');
// member's profile activity
add_action('bp_member_activity_filter_options', 'ee_buddypress_activity_filter');
// Group's activity
add_action('bp_group_activity_filter_options', 'ee_buddypress_activity_filter');

/* Adds the EE4 activity type to the admin interface */
function ee_buddypress_activity_actions()
{
    global $bp;

    bp_activity_set_action(
        $bp->activity->id,
        'ee_event_registration',
        __('Registered for an event', 'ee_buddypress'),
        'bp_activity_format_activity_action_activity_update'
    );

    do_action('bp_activity_register_activity_actions');
}


add_action('bp_register_activity_actions', 'ee_buddypress_activity_actions');


/* Auto-populate the registration forms based on profile information */
function ee_buddypress_filter_answer_for_WPUser($value, $registration, $question_id)
{
    if (empty($value)) {
        $current_user = wp_get_current_user();

        if ($current_user instanceof WP_User) {
            switch ($question_id) {
                case 1: // EE4 Question ID
                    $value = $current_user->get('first_name');
                    break;

                case 2:
                    $value = $current_user->get('last_name');
                    break;

                case 3:
                    $value = $current_user->get('user_email');
                    break;

                /* Customize the following to automatically add profile data to your registration forms.*/ /*
                case 6: //EE4 Question ID
                    $value = xprofile_get_field_data( 'City' ,bp_loggedin_user_id());
                    break;
                */

                default:
            }
        }
    }
    return $value;
}


add_filter(
    'FHEE__EEM_Answer__get_attendee_question_answer_value__answer_value',
    'ee_buddypress_filter_answer_for_WPUser',
    10,
    3
);

