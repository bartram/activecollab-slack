<?php

/**
 * @param $object
 * @throws InvalidInstanceError
 * @throws NotImplementedError
 */
function slack_handle_on_object_inserted($object) {

    if ($object instanceof Task) {

        $project    = $object->getProject();
        $channel    = slack_get_channel( $project->getCustomField1() );
        $token      = slack_get_token( $project->getCustomField2() );

        if ($channel && $token) {

            $task_id    = $object->getTaskId();
            $task_name  = $object->getName();
            $task_url   = $object->getViewUrl();

            $message    = "New task *<{$task_url}|#{$task_id}: {$task_name}>*";
            $user       = $object->assignees()->getAssignee();

            // Tasks can be without assignees
            if ($user) {
                $user_name = $user->getName();

                // @todo make this an object...
                if ($slack_user = slack_get_user_by_email($user->getEmail(), $token)) {
                    $user_name = "<@{$slack_user['id']}>";
                }

                $message .= " assigned to *{$user_name}*";
            }

            slack_post_message($message, $channel, $token);
        }
    }

    if ($object instanceof TaskComment) {

        $project    = $object->getProject();
        $channel    = slack_get_channel( $project->getCustomField1() );
        $token      = slack_get_token( $project->getCustomField2() );

        if ($channel && $token) {

            $task       = $object->getParent();
            $task_id    = $task->getTaskId();
            $task_name  = $task->getName();
            $task_url   = $task->getViewUrl();

            // Every comment must have a user name
            $user       = $object->getCreatedBy();
            $user_name  = $user->getName();

            // @todo make this an object...
            if ($slack_user = slack_get_user_by_email($user->getEmail(), $token)) {
                $user_name = "<@{$slack_user['id']}>";
            }

            # Remove HTML tags but make sure to include line breaks
            $message    = "New comment by *{$user_name}* on task *<{$task_url}|#{$task_id}: {$task_name}>*\n>>>";
            $message   .= strip_tags(str_replace('</p>', "</p>\n\n", $object->getBody()));

            slack_post_message($message, $channel, $token);
        }
    }
}