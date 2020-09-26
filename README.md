# stupid-forward-auth

Yet another forward-authenticating app for a reverse proxy, PHP edition. Should support any proxy server with forward authentication support.

This is effectively a heavily stripped-down version of [Twain](https://github.com/hjbotha/twain), because my requirements changed and I wanted my auth script to be easier to configure and audit.

This will never include any other means of authentication apart from hard-coded basic authentication. It's not an authentication gateway, just rudimentary access control. If you want LDAP, SSO or MFA, look elsewhere.

What it does:
- Allow access to sites based on whatever PHP logic you can devise

## How to deploy
- Clone the project onto your php-enabled web server
- Point your http server webroot at the public directory
- Configure your proxy to send forward-auth requests to that server
- Copy rules.example.php to rules.php and edit according to your needs

The contrib directory contains an example traefik configuration file. To have traefik authenticate requests to a given service, add this label:  
traefik.http.routers.\<service-name\>.middlewares=stupid-forward-auth@file

## Notes
- Exact proxy forward auth behaviour might differ, but generally, if the script responds with 2xx, the request will be allowed, while a 4xx response would result in the request being blocked.
- Uses [IP-Lib](https://github.com/mlocati/ip-lib) to check if IP addresses are in given ranges.