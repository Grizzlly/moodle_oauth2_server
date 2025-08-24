# Turn Moodle into an OAuth2 server

This plugin is held together by duct tape. It was inspired by the [local_oauth2](https://github.com/enovation/moodle-local_oauth2) plugin.

This plugin actually features a `userinfo` endpoint to get information about a user by providing a valid access token.

## Installation

1. Under the `local` folder, create a new folder called `oauth2_server` and copy all files present in this repo there. Make sure to also include the submodule.
2. To add a client, you have to do it by editing the `mdl_local_oauth2_server_clients` table, inserting a new row.
3. Profit! Point your OAuth2 client to the respective `login`, `token`, and `userinfo` endpoints provided by this plugin.

## Caveats

1. No PKCE.
2. Authorization requests are implicitly approved.
3. No refresh token.
4. Cannot impersonate the user for the Moodle API.

Having said this, this plugin should be safe to use with clients that can store secrets, and should be good enough if you just need user information.

# Contributing

Feel free to send PRs.
