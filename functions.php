<?php

/**
 * @param $email
 * @param $token
 * @return mixed
 */
function slack_get_user_by_email($email, $token) {

    static $users;

    if ($token) {
        if (!$users) {
            // @todo cache users.list
            $slack = new Slack($token);
            $response = $slack->call('users.list');

            if ($response['ok']) {
                $users = $response['members'];
            }
        }

        foreach ($users as $user) {
            if ($user['profile']['email'] == $email) {
                return $user;
            }
        }
    }
}

/**
 * @param $message
 * @param $channel
 * @param $token
 */
function slack_post_message($message, $channel, $token) {
    if ($token) {
        $slack = new Slack($token);

        $slack->call('chat.postMessage', array(
            'channel'       => $channel,
            'text'          => $message,
            'username'      => 'ActiveCollab',
            'as_user'       => FALSE,
            'icon_url'      => defined('ASSETS_URL') ? ASSETS_URL . '/images/system/default/application-branding/logo.80x80.png'  : '',
            'link_names'    => 1
        ));
    }
}

/**
 * @param string $customField1
 * @return string
 */
function slack_get_channel($customField1 = '') {
    $default = defined('SLACK_DEFAULT_CHANNEL') ? SLACK_DEFAULT_CHANNEL : '#general';
    return !empty($customField1) ? $customField1 : $default;
}

/**
 * @param string $customField2
 * @return mixed|string
 */
function slack_get_token($customField2 = '') {
    $default = defined('SLACK_API_TOKEN') ? SLACK_API_TOKEN : '';
    return !empty($customField2) && defined('SLACK_API_TOKEN_' . strtoupper($customField2)) ?
        constant('SLACK_API_TOKEN_' . strtoupper($customField2)) : $default;

}