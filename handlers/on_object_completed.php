<?php

/**
 * @param $object
 * @throws NotImplementedError
 */
function slack_handle_on_object_completed($object) {

    if ($object instanceof Task) {

        $project    = $object->getProject();
        $channel    = slack_get_channel( $project->getCustomField1() );
        $token      = slack_get_token( $project->getCustomField2() );

        if ($channel && $token) {

            $task_id    = $object->getTaskId();
            $task_name  = $object->getName();
            $task_url   = $object->getViewUrl();

            // There's no object named getCompletedBy()...
            $user_name  = $object->getCompletedByName();

            // @todo make this an object...
            if ($slack_user = slack_get_user_by_email($object->getCompletedByEmail(), $token)) {
                $user_name = "<@{$slack_user['id']}>";
            }

            $message = "Task completed *<{$task_url}|#{$task_id}: {$task_name}>* by *{$user_name}*";

            slack_post_message($message, $channel, $token);
        }
    }
}