<?php

function slack_handle_on_object_inserted($object) {

  if (defined('SLACK_API_TOKEN')) {

    $slack = new Slack(SLACK_API_TOKEN);

    if ($object instanceof Task) {

      $project = $object->getProject();
      if ($channel = $project->getCustomField1()) {

        //$slack_users = $slack->call('users.list');

        $id     = $object->getTaskId();
        $url    = $object->getViewUrl();
        $name   = $object->getName();

        $message = "New task *<{$url}|#{$id}: {$name}>*";

        $assignees = $object->assignees();
        //$assignees_list = array();

        $user = $assignees->getAssignee();
        if ($user) {

          $user_name = $user->getName();
          // @todo make this an object...
          if ($slack_user = slack_get_user_by_email($user->getEmail())) {
            $user_name = "@{$slack_user['name']}";
          }
          $message .= " assigned to {$user_name}";

        }

        $slack->call('chat.postMessage', array(
          'channel'     => $channel,
          'text'        => $message,
          'username'    => 'ActiveCollab',
          'as_user'     => FALSE,
          'icon_url'    => defined('ASSETS_URL') ? ASSETS_URL . '/images/system/default/application-branding/logo.40x40.png'  : ''
        ));

      }
    }
    if ($object instanceof TaskComment) {

      $project = $object->getProject();
      if ($channel = $project->getCustomField1()) {

        $created_by = $object->getCreatedByName();
        //$url = $object->getViewUrl();

        $task       = $object->getParent();
        $task_id    = $task->getTaskId();
        $task_name  = $task->getName();
        $task_url   = $task->getViewUrl();

        $body = strip_tags($object->getBody());

        $slack->call('chat.postMessage', array(
          'channel'     => $channel,
          'text'        => "New comment by *$created_by* on task *<{$task_url}|#{$task_id}: {$task_name}>*",
          'username'    => 'ActiveCollab',
          'as_user'     => FALSE,
          'icon_url'    => defined('ASSETS_URL') ? ASSETS_URL . '/images/system/default/application-branding/logo.40x40.png'  : ''
        ));
        $slack->call('chat.postMessage', array(
          'channel'     => $channel,
          'text'        => ">>>{$body}",
          'username'    => 'ActiveCollab',
          'as_user'     => FALSE,
          'icon_url'    => defined('ASSETS_URL') ? ASSETS_URL . '/images/system/default/application-branding/logo.40x40.png'  : ''
        ));
      }
    }

  }

}
