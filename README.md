# activecollab-slack

Slack integration for Active Collab 4. Following events are pushed to a pre-defined channel:
- new task
- new comments
- completed tasks


## Requirements

- Active Collab 4
- custom field 1 is not yet in use for projects


## Installation

1. [Download sources](https://github.com/bartram/activecollab-slack/archive/master.zip) and extract them to `custom/modules` within your Active Collab.
2. Go to [slack.com](https://api.slack.com/web) and issue an auth token.
3. Open your `config/config.php` and set the SLACK_API_TOKEN: `define('SLACK_API_TOKEN', 'xoxp-YOUR-TOKEN-HERE');`.
4. Login as admin and install module via "Administration → Modules".
5. Go to "Administration → Project Settings" and enable the first custom field.


## Configuration

The custom field will now appear in project settings. Enter your channel name here.


## License

Open source licensed under the MIT license (see LICENSE file for details).