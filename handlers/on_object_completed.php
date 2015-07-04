<?php

function slack_handle_on_object_completed($object) {
    if (defined('SLACK_API_TOKEN')) {

        $slack = new Slack(SLACK_API_TOKEN);

        if ($object instanceof Task) {

            $project = $object->getProject();
            if ($channel = $project->getCustomField1()) {

                //$slack_users = $slack->call('users.list');

                $id     = $object->getTaskId();
                $url    = $object->getViewUrl();
                $name   = $object->getName();

                $message = "Task completed *<{$url}|#{$id}: {$name}>*";

                $assignees = $object->assignees();
                //$assignees_list = array();

                $user = $assignees->getAssignee();
                if ($user) {

                    $user_name = $user->getName();

                    // @todo make this an object...
                    if ($slack_user = slack_get_user_by_email($user->getEmail())) {
                        $user_name = "@{$slack_user['name']}";
                    }
                    $message .= " by {$user_name}";

                }

                $slack->call('chat.postMessage', array(
                    'channel'   => $channel,
                    'text'      => $message,
                    'username'  => 'ActiveCollab',
                    'as_user'   => FALSE,
                    'icon_url'  => defined('ASSETS_URL') ? ASSETS_URL . '/images/system/default/application-branding/logo.40x40.png'  : ''
                ));

            }
        }
    }
}
